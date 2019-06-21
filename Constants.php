<?php
namespace App\Infrastructure;

class Constants{
    
    public static $Value_True = 1;
    public static $Value_False = 0;
    public static $isDeleteTrue = 1;
    public static $isDeleteFalse = 0;
    public static $Status_Active = 1;
    public static $Status_InActive = 0;
    public static $Status_Delete = 2;
   
    public static $SortIndex = 'id';
    public static $SortIndexASC = 'ASC';
    public static $SortIndexDESC = 'DESC';
    public static $TotalItemsCountColumn = "TotalItemsCount";
    public static $PageIndex = 'PageIndex';
    
    public static $displayDateFormatForAll = 'd-m-Y';
    public static $displayDateTimeFormatForAll = 'd-m-Y H:i:s';
    public static $DefaultDateTimeFormat = 'Y-m-d H:i:s';
    public static $dateFormatForDisplayDate = 'mm/dd/yyyy';
    public static $displayDateFormat = 'yyyy-MM-dd';  
    public static $databaseStoredDateFormat = 'Y-m-d';
    public static $YmdDateFormat = 'Y-m-d';
    
    public static $websiteTitle = "Project Name";
    public static $projectName = 'Project Name';

    public static $encrypt = 'encrypt';
    public static $decrypt = 'decrypt';
    
    public static $QueryStringUserID = 'UsrID';
    public static $QueryStringDepartmentID = 'DptID';
    public static $QueryStringCMSID = 'CMSID';
    public static $QueryStringPortfolioID = 'PRTID';

    
    public static $profile_photouploadpath='uploads/user_profilephoto/';
    public static $documentsUploadPath = 'uploads/documents/';
    public static $portfolioUploadPath = 'uploads/portfolio/';


    public static $SenderEmail = 'riddhi.patel@aditmicrosys.com';
    public static $adminEmail = 'rohit.bhalani01@gmail.com';
    public static $ForgotPasswordSenderName = 'Rohit Patel';
    public static $emailThankYouText = "Project Name";
    public static $emailFooterCopyRightText = "Project Name";
    public static $emailLogo = "/resources/assets/images/logo.png";
    
   
    
    public static $user_profile_photo='user'; 
    public static $tableNameDepartment = 'lu_department';
    public static $tableNameUser = 'user';
    public static $tableNameCMS = 'cms';
    public static $tableNamePortfolio = 'portfolio';


    public static $defaultKey = 'id';


    public static $isForHeader = 1;
    public static $isForFooter = 0;
    
    public static $parent_id = 0;
    
    public static $defaultPageSizeCount = 10;

}
