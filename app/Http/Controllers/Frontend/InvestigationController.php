<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\UsefulLink;
use App\Models\Admin\AppSettings;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Models\Admin\Investigation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InvestigationController extends Controller
{
    /**
     * Method for show investigation page
     */
    public function index(){
        $page_title                 = "| Investigation";
        $hospital_tests             = Investigation::where('status',true)->where('home_service',false)->get();
        $useful_links               = UsefulLink::where('status',true)->get();
        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();

        return view('frontend.pages.investigation',compact(
            'page_title',
            'hospital_tests',
            'useful_links',
            'contact',
            'app_settings',
            'footer',
            'news_letter',
        ));
    }
    /**
     * Method for search investigation
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
    */
    public function search(Request $request){
        $page_title  = "| Investigation";
        $validator   = Validator::make($request->all(),[
            'test' => 'nullable',
        ]);
        if($validator->fails()){
           return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }

        if($request->test == ""){
            $hospital_tests         = Investigation::get();
        }

        $hospital_tests             = Investigation::where('name','like','%'.$request->test.'%')->get();
        $useful_links               = UsefulLink::where('status',true)->get();
        $section_slug               = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $search_string              = $request->test;
        
        return view('frontend.pages.investigation',compact(
            'page_title',
            'hospital_tests',
            'search_string',
            'useful_links',
            'contact',
            'app_settings',
            'footer',
            'news_letter',
        ));
    }
}
