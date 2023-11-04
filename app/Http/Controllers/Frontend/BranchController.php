<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\UsefulLink;
use App\Models\Admin\AppSettings;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Http\Controllers\Controller;
use App\Models\Admin\HospitalBranch;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Method for show branch page
     */
    public function index(){
        $page_title                 = "| Branch";
        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $branches                   = HospitalBranch::where('status',true)->get();
        $useful_links               = UsefulLink::where('status',true)->get();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        
        return view('frontend.pages.branch',compact(
            'page_title',
            'branches',
            'useful_links',
            'contact',
            'app_settings',
            'footer',
            'news_letter',
        ));
    }
    /**
     * Method for search branch
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
    */
    public function search(Request $request){
        $page_title  = "| Branch";
        $validator   = Validator::make($request->all(),[
            'branch' => 'nullable',
        ]);
        if($validator->fails()){
           return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }

        if($request->branch == ""){
            $branches                   = HospitalBranch::get();
        }

        $branches                   = HospitalBranch::where('name','like','%'.$request->branch.'%')->get();
        $useful_links               = UsefulLink::where('status',true)->get();
        $section_slug               = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $search_string              = $request->branch;

        return view('frontend.pages.branch',compact(
            'page_title',
            'branches',
            'search_string',
            'useful_links',
            'contact',
            'app_settings',
            'footer',
            'news_letter',
        ));
    }
}
