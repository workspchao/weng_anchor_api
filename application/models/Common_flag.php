<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Common_flag
 *
 * @author lichao
 */
class Common_flag {
    //put your code here
    
//    const USER_ROLE_ID_ADMIN                = 0;
    
    const FLAG_YES_TINYINT = 1;
    const FLAG_NO_TINYINT = 0;
    const FLAG_YES_CHAR = 'Y';
    const FLAG_NO_CHAR = 'N';
    const FLAG_YES_BOOL = TRUE;
    const FLAG_NO_BOOL = FALSE;
    
    const USER_MEMBERSHIP_ID_NO_MEMBER            = 1;
    const USER_MEMBERSHIP_ID_GOLD_MEMBER          = 2;
    const USER_MEMBERSHIP_ID_DIAMOND_MEMBER       = 3;
    
    const USER_REG_PLATFORM_ANDROID         = 1;
    const USER_REG_PLATFORM_IOS             = 2;
    const USER_REG_PLATFORM_ADMIN_WEB       = 3;
    
    const LOGIN_ACCOUNT_IS_ACTIVE_INACTIVE  = 0;
    const LOGIN_ACCOUNT_IS_ACTIVE_ACTIVE    = 1;
    
    const LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_CONTACT_MOBILE = 1;
    const LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_EMAIL = 2;
    const LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_USERNAME = 3;
    const LOGIN_ACCOUNT_LOGIN_TYPE_WECHAT   = 4;
    const LOGIN_ACCOUNT_LOGIN_TYPE_QQ       = 5;
    const LOGIN_ACCOUNT_LOGIN_TYPE_WEIBO    = 6;
    const LOGIN_ACCOUNT_LOGIN_TYPE_FACEBOOK = 7;
    
    const COMMON_LOG_ACTION_LOGIN = 1;
    const COMMON_LOG_ACTION_LOGOUT = 2;
    const COMMON_LOG_ACTION_LOGIN_FAILD = 3;
    
    const OTP_TYPE_SMS = 1;
    const OTP_TYPE_EMAIL = 2;
    
    
}
