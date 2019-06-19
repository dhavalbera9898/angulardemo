<?php

namespace App\Http\Controllers\Backend\Serviceproduct;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Serviceproduct\ServiceproductRepository;
use App\Http\Requests\Backend\Serviceproduct\ManageServiceproductRequest;

/**
 * Class ServiceproductsTableController.
 */
class ServiceproductsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var ServiceproductRepository
     */
    protected $serviceproduct;

    /**
     * contructor to initialize repository object
     * @param ServiceproductRepository $serviceproduct;
     */
    public function __construct(ServiceproductRepository $serviceproduct)
    {
        $this->serviceproduct = $serviceproduct;
    }

    /**
     * This method return the data of the model
     * @param ManageServiceproductRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageServiceproductRequest $request)
    {
        return Datatables::of($this->serviceproduct->getForDataTable())
        ->escapeColumns(['id'])
        ->addColumn('price', function ($serviceproduct) {
            return '₹'.$serviceproduct->price;
        }) 
        ->addColumn('status', function ($propertypackage) {
            return $propertypackage->status_label;
        }) ->addColumn('category', function ($propertypackage) {
            return $propertypackage->category;
        })
        ->addColumn('created_at', function ($serviceproduct) {
            return Carbon::parse($serviceproduct->created_at)->format('d/m/Y H:i:s');
        })
        ->addColumn('actions', function ($serviceproduct) {
            return $serviceproduct->action_buttons;
        })
        ->make(true);
    }
}
