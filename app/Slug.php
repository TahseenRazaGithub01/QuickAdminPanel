<?php
namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
class Slug extends Model
{
    protected $table = 'slugs';
    protected $primaryKey = 'id';
    protected $forignKey = 'obj_id';
    protected $table_field_name = 'table_name';
    protected $slug_field_name = 'slug';

    protected $fillable = [];
    protected $guarded  = [];

    public function blog() {
        return $this->belongsTo('App\Blog', 'obj_id', 'blog_id');
    }

    public function deleteSlug($obj_id, $table_name){
        $this->where($this->forignKey, $obj_id)->where($this->table_field_name, $table_name)->delete();
        return true;
    }

    public function massdeleteSlug($obj_id, $table_name){
        $this->whereIn($this->forignKey, $obj_id)->where($this->table_field_name, $table_name)->delete();
        return true;
    }

    public function insertSlug($last_id, $params, $table_name, $site_id, $parent_id = 0){
        $return_data = array();

        if(empty($last_id) || empty($params) || empty($table_name)) return;

        foreach($site_id as $site) {
            $check_exist = $this->where($this->table_field_name, $table_name)->where($this->slug_field_name, $params)->where('site_id', $site)->count();
            if($check_exist > 0){
                $return_data['errors'] = ['error' => ['Slug is not unique']];
                $return_data['status'] = false;
                return $return_data;
            }

            $slug_ins = new $this;
            $slug_ins->obj_id = $last_id;
            $slug_ins->table_name = $table_name;
            $slug_ins->page_type = $table_name;
            $slug_ins->slug = $params;
            $slug_ins->site_id = $site;
            $slug_ins->slug_parent_id = $parent_id;
            $slug_ins->created_at = date('Y-m-d H:i:s');
            $slug_ins->updated_at = date('Y-m-d H:i:s');
            $slug_ins->save();
        }

        $return_data['status'] = true;
        return $return_data;
    }


    public function updateSlug($last_id, $params, $table_name, $site_id, $parent_id = 0, $old_slug = 0){
        $return_data = [];
        if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        }

        if(empty($last_id) || empty($params) || empty($table_name)) return;
            // checking for slug if found on same obj id
            // then ok
            // else if not found on same obj id but
            // found on some different id
            // then it means this slug is not unique

        $slugUnique = $this->where('obj_id', '!=', $last_id)->where($this->table_field_name, $table_name)->where($this->slug_field_name, $params)->where('site_id', $site_id)->count();

        if($slugUnique > 0) {
            $return_data['error'] = ['error' => ['Slug is not Unique']];
            $return_data['status'] = false;
            return $return_data;
        }

        $slugCheck = $this->where('obj_id', $last_id)->where($this->table_field_name, $table_name)->get();

        foreach($slugCheck as $check) {
            if(!in_array($check->site_id, $site_id)) {
                $this->where('obj_id', $last_id)->where($this->table_field_name, $table_name)->where('site_id', $check->site_id)->delete();
            }
        }

        /*->where('slug', $params)*/
        foreach($site_id as $site) {
            $checking = $this->where('obj_id', $last_id)->where($this->table_field_name, $table_name)->where('site_id', $site)->count();
            if($checking > 0) {
                $data = $this->where('obj_id', $last_id)->where($this->table_field_name, $table_name)->where('site_id', $site)->first();
                $data->slug_parent_id = $parent_id;
                $data->slug = $params;
                $data->old_slug = $old_slug;
                $data->site_id = $site;
                $data->updated_at = date('Y-m-d H:i:s');
                $data->save();
                $return_data['status'] = true;
            }
            else {

                // if previously this has not assigned any slug so create one for this
                $slug_ins = new $this;
                $slug_ins->obj_id = $last_id;
                $slug_ins->table_name = $table_name;
                $slug_ins->page_type = $table_name;
                $slug_ins->slug = $params;
                $slug_ins->site_id = $site;
                $slug_ins->slug_parent_id = $parent_id;
                $slug_ins->created_at = date('Y-m-d H:i:s');
                $slug_ins->updated_at = date('Y-m-d H:i:s');
                $slug_ins->save();
                $return_data['status'] = true;
            }
        }
        return $return_data;
    }


    public function add_new_slug($data)
    {
        try {
            DB::beginTransaction();
            $this->insert($data);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->catch_exception($e);
            // something went wrong
        }
        return false;
    }
    public function get_slug($link,$siteid){
        $data = $this->where(function($q) use ($link){
            $q->Orwhere('slug', $link)->Orwhere('old_slug', $link);
        })->where('site_id',$siteid)->first();
        return $data;
    }
}
