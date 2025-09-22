<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\PricingPlans;
use App\Http\Requests\admin\StorePricingPlanRequest;
use App\DataTables\PricingPlansDataTable;
use App\Models\admin\Company;

class PricingPlansController extends Controller
{
    public function index(PricingPlansDataTable $dataTable)
    {
        return $dataTable->render('admin.pricing_plans.index');
    }

    public function createOrEdit($id = null)
    {
        $pricingPlan = $id ? PricingPlans::findOrFail($id) : new PricingPlans();
        return view('admin.pricing_plans.form', compact('pricingPlan'));
    }

    public function storeOrUpdate(StorePricingPlanRequest $request)
    {
        $data = $request->validated();
        $pricingPlanId = $request->id;

        // If updating (not creating), check if the status is being changed to inactive
        if ($pricingPlanId) {
            $pricingPlan = PricingPlans::findOrFail($pricingPlanId);
            // Check if status is being changed to inactive (false)
            if (isset($data['status']) && $data['status'] == false && $pricingPlan->status != $data['status']) {
                // Check if any company is associated with this pricing plan
                $isAssigned = Company::where('plan_id', $pricingPlanId)->exists();

                if ($isAssigned) {
                    return redirect()->route('pricing-plans.index')->with('error', 'Plan assigned to companies - cannot deactivate.');
                }
            }
        }

        // Proceed with update or create
        $pricingPlan = PricingPlans::updateOrCreate(
            ['id' => $pricingPlanId], // condition
            $data                     // values to insert/update
        );

        $message = $pricingPlan->wasRecentlyCreated ? 'created successfully' : 'updated successfully';
        return redirect()->route('pricing-plans.index')->with('success', 'Pricing Plan ' . $message);
    }

    public function destroy(PricingPlans $pricingPlan)
{
    // Check if the pricing plan is active
    if ($pricingPlan->status == true) {
        return response()->json([
            'success' => false,
            'error' => 'Plan is active - cannot delete.',
        ], 403);
    }

    // Check if the pricing plan is assigned to any company
    $isAssigned = \App\Models\Company::where('plan_id', $pricingPlan->id)->exists();
    if ($isAssigned) {
        return response()->json([
            'success' => false,
            'error' => 'Plan assigned to companies - cannot delete.',
        ], 403);
    }

    // Proceed with deletion
    $pricingPlan->delete();
    return response()->json([
        'success' => true,
        'message' => 'Pricing Plan deleted successfully',
    ]);
}
}
