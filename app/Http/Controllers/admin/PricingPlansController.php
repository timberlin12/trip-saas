<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\PricingPlans;
use App\Http\Requests\admin\StorePricingPlanRequest;
use App\DataTables\PricingPlansDataTable;

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
        $pricingPlan = PricingPlans::updateOrCreate(
            ['id' => $request->id], // condition
            $data                    // values to insert/update
        );

        $message = $pricingPlan->wasRecentlyCreated ? 'created successfully' : 'updated successfully';
        return redirect()->route('pricing-plans.index')->with('success','Pricing Plan ' . $message);
    }

    public function destroy(PricingPlans $pricingPlan)
    {
        $pricingPlan->delete();
        return response()->json([
            'success' => true,
            'message' => 'Pricing Plan deleted successfully',
        ]);
    }
}
