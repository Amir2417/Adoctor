<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Models\Subscribe;
use Illuminate\Support\Str;
use App\Models\Admin\Doctor;
use Illuminate\Http\Request;
use App\Models\Admin\Journal;
use App\Http\Helpers\Response;
use App\Models\Admin\UsefulLink;
use App\Models\Admin\AppSettings;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Models\Admin\Investigation;
use App\Http\Controllers\Controller;
use App\Models\Admin\ContactRequest;
use App\Models\Admin\HospitalBranch;
use App\Models\Admin\HospitalDepartment;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    /**
     * Method for index page
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function index(){

        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $banner_slug                = Str::slug(SiteSectionConst::BANNER_SECTION);
        $banner                     = SiteSections::getData($banner_slug)->first();
        $login_slug                 = Str::slug(SiteSectionConst::LOG_IN_SECTION);
        $login                      = SiteSections::getData($login_slug)->first();
        $register_slug              = Str::slug(SiteSectionConst::REGISTER_SECTION);
        $register                   = SiteSections::getData($register_slug)->first();
        $section_slug               = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $about                      = SiteSections::getData($section_slug)->first();
        $faq_section_slug           = Str::slug(SiteSectionConst::FAQ_SECTION);
        $faq                        = SiteSections::getData($faq_section_slug)->first();
        $testimonial_section_slug   = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
        $testimonial                = SiteSections::getData($testimonial_section_slug)->first();
        $how_its_work_section_slug  = Str::slug(SiteSectionConst::HOW_ITS_WORK);
        $how_its_work               = SiteSections::getData($how_its_work_section_slug)->first();
        $journal_section_slug       = Str::slug(SiteSectionConst::WEB_JOURNAL);
        $journal_top                = SiteSections::getData($journal_section_slug)->first();
        $journals                   = Journal::where('status',true)->get();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $hospital_departments       = HospitalDepartment::where('status',true)->get();
        $branches                   = HospitalBranch::where('status',true)->get();
        $useful_links               = UsefulLink::where('status',true)->get();
        $hospital_tests             = Investigation::where('status',true)->get();
        
        return view('frontend.index',compact(
            'contact',
            'banner',
            'login',
            'register',
            'about',
            'faq',
            'testimonial',
            'how_its_work',
            'journal_top',
            'journals',
            'news_letter',
            'app_settings',
            'footer',
            'hospital_departments',
            'branches',
            'useful_links',
            'hospital_tests'
        ));
    }
    /**
     * Method for show doctor page
     */
    public function doctors(){

        $page_title                 = "| Find Doctor";
        $login_slug                 = Str::slug(SiteSectionConst::LOG_IN_SECTION);
        $login                      = SiteSections::getData($login_slug)->first();
        $register_slug              = Str::slug(SiteSectionConst::REGISTER_SECTION);
        $register                   = SiteSections::getData($register_slug)->first();
        $doctors                    = Doctor::where('status',true)->inRandomOrder()->get();
        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $branches                   = HospitalBranch::where('status',true)->get();
        $departments                = HospitalDepartment::where('status',true)->get();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $useful_links               = UsefulLink::where('status',true)->get();

        return view('frontend.pages.find-doctors',compact(
            'page_title',
            'login',
            'register',
            'contact',
            'doctors',
            'branches',
            'news_letter',
            'app_settings',
            'footer',
            'departments',
            'useful_links'
        ));
    }
    /**
     * Method for get all departments based on branch
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function getBranchDepartments(Request $request) {

        $validator    = Validator::make($request->all(),[
            'branch'  => 'required|integer',           
        ]);
        if($validator->fails()) {
            return Response::error($validator->errors()->all());
        }

        $branch  = HospitalBranch::with(['departments' => function($department) {
            $department->with(['department']);
        }])->find($request->branch);
        if(!$branch) return Response::error(['Branch Not Found'],404);

        return Response::success(['Data fetch successfully'],['branch' => $branch],200);

    }
    /**
     * Method for search doctor
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
    */
    public function searchDoctor(Request $request){
      
        $page_title                 = "| Doctors";
        $useful_links               = UsefulLink::where('status',true)->get();
        $login_slug                 = Str::slug(SiteSectionConst::LOG_IN_SECTION);
        $login                      = SiteSections::getData($login_slug)->first();
        $register_slug              = Str::slug(SiteSectionConst::REGISTER_SECTION);
        $register                   = SiteSections::getData($register_slug)->first();
        $section_slug               = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();

        $validator = Validator::make($request->all(),[
            'branch'       => 'nullable',
            'department'   => 'nullable',
            'doctor'       => 'nullable',
        ]);
        if($validator->fails()) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }
        if($request->branch && $request->department && $request->doctor){
            
            $doctors    = Doctor::where('hospital_branch_id',$request->branch)->where('hospital_department_id',$request->department)->where('name','like','%'.$request->doctor.'%')->get(); 
            
        }else if($request->branch && $request->department){
            $doctors    = Doctor::where('hospital_branch_id',$request->branch)->where('hospital_department_id',$request->department)->get();
        }
        else{
            $doctors    = Doctor::where('name','like','%'.$request->doctor.'%')->get();
        }

       
        $branches   = HospitalBranch::where('status',true)->get();

        $searchBranch     = $request->branch;
        $searchDepartment = $request->department;
        $searchDoctor      = $request->doctor;

        return view('frontend.pages.find-doctors',compact(
            'page_title',
            'login',
            'register',
            'doctors',
            'searchBranch',
            'searchDepartment',
            'searchDoctor',
            'branches',
            'useful_links',
            'contact',
            'app_settings',
            'footer',
            'news_letter',
        ));     
    }
    /**
     * Method for show about page
     */
    public function about(){

        $page_title                 = "| About";
        $login_slug                 = Str::slug(SiteSectionConst::LOG_IN_SECTION);
        $login                      = SiteSections::getData($login_slug)->first();
        $register_slug              = Str::slug(SiteSectionConst::REGISTER_SECTION);
        $register                   = SiteSections::getData($register_slug)->first();
        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $section_slug               = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $about                      = SiteSections::getData($section_slug)->first();
        $testimonial_section_slug   = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
        $testimonial                = SiteSections::getData($testimonial_section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $useful_links               = UsefulLink::where('status',true)->get();

        return view('frontend.pages.about',compact(
            'page_title',
            'login',
            'register',
            'contact',
            'about',
            'news_letter',
            'testimonial',
            'app_settings',
            'footer',
            'useful_links'
        ));
    }
    /**
     * Method for show all faq 
     */
    public function faqs(){

        $page_title                 = "| Faq";
        $login_slug                 = Str::slug(SiteSectionConst::LOG_IN_SECTION);
        $login                      = SiteSections::getData($login_slug)->first();
        $register_slug              = Str::slug(SiteSectionConst::REGISTER_SECTION);
        $register                   = SiteSections::getData($register_slug)->first();
        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $section_slug               = Str::slug(SiteSectionConst::FAQ_SECTION);
        $faq                        = SiteSections::getData($section_slug)->first();
        $testimonial_section_slug   = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
        $testimonial                = SiteSections::getData($testimonial_section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $useful_links               = UsefulLink::where('status',true)->get();
        
        return view('frontend.pages.faqs',compact(
            'page_title',
            'login',
            'register',
            'contact',
            'faq',
            'testimonial',
            'app_settings',
            'footer',
            'news_letter',
            'useful_links'
        ));
    }
    /**
     * Method for show all journals 
     */
    public function journals(){

        $page_title                 = "| Web Journal";
        $login_slug                 = Str::slug(SiteSectionConst::LOG_IN_SECTION);
        $login                      = SiteSections::getData($login_slug)->first();
        $register_slug              = Str::slug(SiteSectionConst::REGISTER_SECTION);
        $register                   = SiteSections::getData($register_slug)->first();
        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $journal                    = Journal::where('status',true)->paginate(6);
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $useful_links               = UsefulLink::where('status',true)->get();

        return view('frontend.pages.journals',compact(
            'page_title',
            'login',
            'register',
            'contact',
            'journal',
            'app_settings',
            'footer',
            'news_letter',
            'useful_links'
        ));
    }
    /**
     * Method for show journal details page 
     */
    public function journalDetails($slug){

        $page_title                 = "| Journal Details";
        $login_slug                 = Str::slug(SiteSectionConst::LOG_IN_SECTION);
        $login                      = SiteSections::getData($login_slug)->first();
        $register_slug              = Str::slug(SiteSectionConst::REGISTER_SECTION);
        $register                   = SiteSections::getData($register_slug)->first();
        $journal                    = Journal::where('slug',$slug)->first();
        if(!$journal) abort(404);
        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $total_journals             = Journal::where('status',true)->where('slug', '!=',$slug)->get();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $useful_links               = UsefulLink::where('status',true)->get();

        return view('frontend.pages.journal-details',compact(
            'page_title',
            'contact',
            'login',
            'register',
            'journal',
            'total_journals',
            'app_settings',
            'footer',
            'news_letter',
            'useful_links'
        ));
    }
    /**
     * Method for show contact us page
     */
    public function contact(){

        $page_title                 = "| Contact";
        $login_slug                 = Str::slug(SiteSectionConst::LOG_IN_SECTION);
        $login                      = SiteSections::getData($login_slug)->first();
        $register_slug              = Str::slug(SiteSectionConst::REGISTER_SECTION);
        $register                   = SiteSections::getData($register_slug)->first();
        $section_slug               = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $useful_links               = UsefulLink::where('status',true)->get();

        return view('frontend.pages.contact-us',compact(
            'page_title',
            'contact',
            'login',
            'register',
            'app_settings',
            'footer',
            'news_letter',
            'useful_links'
        ));
    }
    /**
     * Method for sbscribe
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function subscribe(Request $request) {
        $validator      = Validator::make($request->all(),[
            'name'      => "required|string|max:255|",
            'email'     => "required|string|email|max:255|unique:subscribes",
        ]);
        if($validator->fails()) return redirect('/#subscribe-form')->withErrors($validator)->withInput();
        $validated = $validator->validate();
        try{
            Subscribe::create([
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'created_at'    => now(),
            ]);
        }catch(Exception $e) {
            return redirect('/#subscribe-form')->with(['error' => ['Failed to subscribe. Try again']]);
        }
        return redirect(url()->previous() . '/#subscribe-form')->with(['success' => ['Subscription successful!']]);
    }
    /**
     * Method for send contact request
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function contactRequest(Request $request) {

        $validator        = Validator::make($request->all(),[
            'name'        => "required|string|max:255|unique:contact_requests",
            'email'       => "required|string|email|max:255|unique:contact_requests",
            'message'     => "required|string|max:5000",
        ]);
        if($validator->fails()) return back()->withErrors($validator)->withInput();
        $validated = $validator->validate();
        try{
            ContactRequest::create([
                'name'            => $validated['name'],
                'email'           => $validated['email'],
                'message'         => $validated['message'],
                'created_at'      => now(),
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Failed to Contact Request. Try again']]);
        }
        return back()->with(['success' => ['Contact Request successfully send!']]);
    }
    /**
     * Method for show useful links 
     */
    public function link($slug){
        $link                       = UsefulLink::where('slug',$slug)->first();
        $login_slug                 = Str::slug(SiteSectionConst::LOG_IN_SECTION);
        $login                      = SiteSections::getData($login_slug)->first();
        $register_slug              = Str::slug(SiteSectionConst::REGISTER_SECTION);
        $register                   = SiteSections::getData($register_slug)->first();
        $useful_links               = UsefulLink::where('status',true)->get();
        $section_slug               = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();

        return view('frontend.pages.link',compact(
            'link',
            'login',
            'register',
            'useful_links',
            'contact',
            'app_settings',
            'footer',
            'news_letter',
        ));
    }
}
