<?php

namespace App\Constants;

class GlobalConst {
    const USER_PASS_RESEND_TIME_MINUTE = "1";

    const ACTIVE = true;
    const BANNED = false;
    const DEFAULT_TOKEN_EXP_SEC = 3600;

    const VERIFIED   = 1;
    const APPROVED   = 1;
    const PENDING    = 2;
    const REJECTED   = 3;
    const DEFAULT    = 0;
    const UNVERIFIED = 0;

    const APPOINTMENT_TYPE_NEW      = "NEW";
    const APPOINTMENT_TYPE_REPORT   = "REPORT";
    const APPOINTMENT_TYPE_FOLLOWUP = "FOLLOWUP";

    const GENDER_MALE      = "MALE";
    const GENDER_FEMALE    = "FEMALE";
    const GENDER_OTHER     = "OTHER";
    const UNKNOWN          = "UNKNOWN";

    const SETUP_PAGE = 'SETUP_PAGE';
    const USEFUL_LINK_PRIVACY_POLICY = "PRIVACY_POLICY";

    const CASH_PAYMENT    = "Cash Payment";



 }