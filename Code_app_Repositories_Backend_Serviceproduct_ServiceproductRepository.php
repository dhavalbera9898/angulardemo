<?php

namespace App\Repositories\Backend\Serviceproduct;

use DB;
use Carbon\Carbon;
use App\Models\Serviceproduct\Serviceproduct;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductFeatures\ProductFeatures;
use Image;
/**
 * Class ServiceproductRepository.
 */
class ServiceproductRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Serviceproduct::class;
    protected $upload_path;
    protected $storage;


    public function __construct()
    {
    	$this->upload_path = 'img'.DIRECTORY_SEPARATOR.'serviceproduct'.DIRECTORY_SEPARATOR;

    	$this->storage = Storage::disk('public');

    }

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
    	return $this->query()
    	->leftjoin(config('module.servicecategories.table'), config('module.servicecategories.table').'.id', '=', config('module.serviceproducts.table').'.servicecat_id')
    	->leftjoin(config('module.services.table'), config('module.services.table').'.id', '=', config('module.serviceproducts.table').'.service_id')
    	->select([
    		config('module.serviceproducts.table').'.id',
    		config('module.serviceproducts.table').'.servicecat_id',
    		config('module.serviceproducts.table').'.title',
    		config('module.serviceproducts.table').'.price',
    		config('module.serviceproducts.table').'.status',
    		config('module.serviceproducts.table').'.redeem_points',
    		config('module.serviceproducts.table').'.created_at',
    		config('module.servicecategories.table').'.title as category_title',
    		config('module.services.table').'.title as service_title',
    		config('module.serviceproducts.table').'.updated_at',
    	]);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {

    	$input['slug'] = str_slug($input['title']);
    	$input['price'] = $input['price'];
    	$input['short_description'] = $input['short_description'];
    	$input['status'] = $input['status'];
    	if(isset($input['servicecat_id'])){
    		$input['product_id'] = $this->generateproductid($input['servicecat_id']);
    	}else{
    		$input['product_id'] = $this->generateproductid($input['service_id']);
    	}
    	$input['service_id'] = $input['service_id'];
    	if(isset( $input['servicecat_id'])){

    		$input['servicecat_id'] = $input['servicecat_id'];
    	}else{            
    		$input['servicecat_id'] = '';
    	}

    	if(isset($input['features']) && count($input['features']>0)){
    		$features_is = [];
    		$features = ProductFeatures::pluck('name');
    		if(count($features)==0){
    			foreach ($input['features'] as $key => $value) {
    				$result=ProductFeatures::create([
    					'name' => $value
    				]);
    				$features_is[]=$result->id;
    			}
    			$input['features_id'] = json_encode($features_is);
    		}else{

    			foreach ($input['features'] as $key => $value) {
    				if(is_numeric($value)){
    					$features_is[] = $value;
    				}else{
    					$is_available=ProductFeatures::where('name',$value)->first();
    					if(!isset($is_available)){
    						$result=ProductFeatures::create([
    							'name' => $value
    						]);
    						$features_is[]=$result->id;
    					}
    				}

    			}

    			$input['features_id'] = json_encode($features_is);
    		}
    	}


    	if(isset($input['attribute'])){
    		$input['attribute']=json_encode($input['attribute']);
    	}
      if(isset($input['states'])){
        $input['states']=json_encode($input['states']);
      }

      if(isset($input['downlink']) && count($input['downlink'])>0){
        if(count($input['downlink'])==count($input['downlinklable'])){
         $downlink=array();    
         foreach ($input['downlink'] as $key => $value) {
          $downlink[$input['downlinklable'][$key]]=$value;
        }
        $input['downlink']=json_encode($downlink);
      }
    }

    DB::transaction(function () use ($input) {
      $input = $this->uploadImage($input);
      if (Serviceproduct::create($input)) {
       return true;
     }

     throw new GeneralException(trans('exceptions.backend.serviceproducts.create_error'));
   });
  }

     /**
     * For Generate Product Id
     *
     * @param $category_id
     * @throws 
     * @return product_id
     */

     public function generateproductid($category_id)
     {
     	$maxid=Serviceproduct::max('id');
     	$id=$maxid+1;
     	$product_id='acr'.$id.'-'.$category_id.'';
     	return $product_id;
     }

    /**
     * For updating the respective Model in storage
     *
     * @param Serviceproduct $serviceproduct
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Serviceproduct $serviceproduct, array $input)
    {

    	$input['slug'] = str_slug($input['title']);
    	$input['price'] = $input['price'];
    	$input['short_description'] = $input['short_description'];
    	$input['service_id'] = $input['service_id'];
    	if(isset( $input['servicecat_id'])){

    		$input['servicecat_id'] = $input['servicecat_id'];
    	}else{            
    		$input['servicecat_id'] = '';
    	}

    	if(isset($input['features']) && count($input['features']>0)){
    		$features_is = [];
    		$features = ProductFeatures::pluck('name');
    		if(count($features)==0){
    			foreach ($input['features'] as $key => $value) {
    				$result=ProductFeatures::create([
    					'name' => $value
    				]);
    				$features_is[]=$result->id;
    			}
    			$input['features_id'] = json_encode($features_is);
    		}else{

    			foreach ($input['features'] as $key => $value) {
    				if(is_numeric($value)){
    					$features_is[] = $value;
    				}else{
    					$is_available=ProductFeatures::where('name',$value)->first();
    					if(!isset($is_available)){
    						$result=ProductFeatures::create([
    							'name' => $value
    						]);
    						$features_is[]=$result->id;
    					}
    				}

    			}

    			$input['features_id'] = json_encode($features_is);
    		}
    		// $input['features'] = json_encode($input['features']);
    	}
    
    	if(isset($input['attribute'])){
        $input['attribute']=json_encode($input['attribute']);
      }else{
         $input['attribute']='';
      }
      if(isset($input['states'])){
        $input['states']=json_encode($input['states']);
      }





      if(isset($input['downlink']) && count($input['downlink'])>0){
        if(count($input['downlink'])==count($input['downlinklable'])){
         $downlink=array();    
         foreach ($input['downlink'] as $key => $value) {
          $downlink[$input['downlinklable'][$key]]=$value;
        }
        $input['downlink']=json_encode($downlink);
      }
    }



        // Uploading Image
    if (array_key_exists('image', $input)) {
      $this->deleteOldFile($serviceproduct);
      $input = $this->uploadImage($input);
    }   

    if ($serviceproduct->update($input))
      return true;

    throw new GeneralException(trans('exceptions.backend.serviceproducts.update_error'));
  }

    /**
     * For deleting the respective model from storage
     *
     * @param Serviceproduct $serviceproduct
     * @throws GeneralException
     * @return bool
     */
    public function delete(Serviceproduct $serviceproduct)
    {
    	if ($serviceproduct->delete()) {
    		return true;
    	}

    	throw new GeneralException(trans('exceptions.backend.serviceproducts.delete_error'));
    }

    /**
     * Upload Image.
     *
     * @param array $input
     *
     * @return array $input
     */
    public function uploadImage($input)
    {


    	if (isset($input['image']) && !empty($input['image'])) {
    		$images=[];
    		foreach ($input['image'] as $key => $image) {
    			$fileName = time().$image->getClientOriginalName();

    			$this->storage->put($this->upload_path.$fileName, file_get_contents($image->getRealPath()));


    			$destinationPath = public_path('img/cart_images');
    			$thumb_img = Image::make( $image->getRealPath())->resize(100, 100);
    			$thumb_img->save($destinationPath.'/'.$fileName,80);
    			$destinationPath = public_path('img/product_list_images');
    			$thumb_img = Image::make( $image->getRealPath())->resize(350, 250);
    			$thumb_img->save($destinationPath.'/'.$fileName,80);

    			$images[]=$fileName;

    		}

    		$input = array_merge($input, ['image' => json_encode($images)]);

    	}

    	return $input;
    }

    /**
     * Destroy Old Image.
     *
     * @param int $id
     */
    public function deleteOldFile($model)
    {
    	$fileName = $model->image;

    	foreach (json_decode($fileName) as $key => $value) {
    		$this->storage->delete($this->upload_path.$value);
    		if(file_exists(public_path('img/cart_images/').$value)){
    			unlink(public_path('img/cart_images/').$value);
    		}
    		if(file_exists(public_path('img/product_list_images/').$value)){
    			unlink(public_path('img/product_list_images/').$value);
    		}
    	}
    	return true;
    }

    /**
     * For Count Of Package storage
     *
     * @return bool
     */
    public function Productlimit(Serviceproduct $serviceproducts, $input)
    {
    	if($input['is_display_home']==1){
    		$count = Serviceproduct::where('is_display_home','1')->where('id','!=',$serviceproducts->id)->get();

    		if (count($count)<3) {
    			return true;
    		}else{
    			return false;
    		}
    	}else{
    		return true;
    	}
    }

    /**
     * For Only One Package Is  storage
     *
     * @return bool
     */
    public function IsRecommended(Serviceproduct $serviceproducts,$input)
    {
    	if($input['is_recommended']==1){

    		$count = Serviceproduct::where('is_recommended','1')->where('id','!=',$serviceproducts->id)->get();

    		if (count($count)==0) {
    			return true;
    		}else{
    			return false;
    		}
    	}else{
    		return true;
    	}
    }
  }
