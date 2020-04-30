<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gate;
use App\Contact;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use url;

class ContactController extends Controller
{
    public function index(){
        abort_if((!getSiteID() > 0), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $contacts = Contact::all();
        return view('admin.contact_us.index', compact('contacts'));
    }
}
