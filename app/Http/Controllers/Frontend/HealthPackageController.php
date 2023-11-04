<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\UsefulLink;
use App\Models\Admin\AppSettings;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Models\Admin\HealthPackage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HealthPackageController extends Controller
{
    /**
     * Method for show health package page
     */
    public function index(){
        $page_title                 = "| Health Package";
        $useful_links               = UsefulLink::where('status',true)->get();
        $packages                   = HealthPackage::where('status',true)->get(); 
        $contact_section_slug       = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($contact_section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        

        return view('frontend.pages.health-package',compact(
            'page_title',
            'useful_links',
            'packages',
            'contact',
            'app_settings',
            'footer',
            'news_letter',
        ));
    }

    /**
     * Method for search health package
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
    */
    public function search(Request $request){
        $page_title  = "| Health Package";
        $validator   = Validator::make($request->all(),[
            'package' => 'nullable',
        ]);
        if($validator->fails()){
           return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }

        if($request->package == ""){
            $packages               = HealthPackage::get();
        }

        $packages                   = HealthPackage::where('name','like','%'.$request->package.'%')->get();
        $useful_links               = UsefulLink::where('status',true)->get();
        $section_slug               = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $contact                    = SiteSections::getData($section_slug)->first();
        $footer_section_slug        = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $footer                     = SiteSections::getData($footer_section_slug)->first();
        $app_settings               = AppSettings::first();
        $news_letter_section        = Str::slug(SiteSectionConst::NEWSLETTER_SECTION);
        $news_letter                = SiteSections::getData($news_letter_section)->first();
        $search_string              = $request->package;
        return view('frontend.pages.health-package',compact(
            'page_title',
            'packages',
            'search_string',
            'useful_links',
            'contact',
            'app_settings',
            'footer',
            'news_letter',
        ));
    }
}
