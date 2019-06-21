/*Remove message bar after few seconds*/
function validateNumericWithDash(evt) {

    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );

    var regex = /[0-9-\b\t]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

function getPageSizeArray() {
    return [{"PageValue": 10,"PageText": "10"},
        {"PageValue": 20,"PageText": "20"},{"PageValue": 30,"PageText": "30"},{"PageValue": 40,"PageText": "40"},{"PageValue": 50,"PageText": "50"}]
}

toastr.options = {
    "closeButton": true,
}

function AngularAjaxCall($angularHttpObject, url, postData, httpMethod, callDataType, contentType) {
    if (contentType == undefined)
        contentType = "application/x-www-form-urlencoded;charset=UTF-8";

    if (callDataType == undefined)
        callDataType = "json";

    return $angularHttpObject({
        method: httpMethod,
        responseType: callDataType,
        url: url,
        data: postData,
        crossDomain: true,
        headers: {'Content-Type': contentType},
        error: function(xhr) {
            if (!userAborted(xhr)) {
                if (xhr.status == 403) {
                    var isJson = false;
                    try {
                        var response = $.parseJSON(xhr.responseText);
                        isJson = true;
                    }
                    catch (e) { }

                    if (isJson && response != null && response.Type == "NotAuthorized" && response.Link != undefined)
                        window.location = baseUrl +response.Link;
                    else
                        window.location = window.baseUrl;
                }
                else {
                    var alertText = "";
                    switch (xhr.status){
                        case 404:
                            alertText =  serverError +  "'Method " + xhr.statusText + "'";
                            break;

                        case 200:
                            break;

                        default :
                            alertText =  serverError + "'" + xhr.statusText + "'";
                            break;
                    }
                    alert(alertText);
                    OnError(alertText, "", "", "");

                }
            }
        }
    });
}



function CopyProperties(theSource,theTarget) {
    for (var propertyName in theTarget)
        //theTarget[propertyName] && (theTarget[propertyName] = theSource[propertyName]);
        theTarget[propertyName] = theSource[propertyName];
}

function ActiveInActiveSubMenu(className){
    if(className == undefined || className == ""){
        console.log('Enter Class Name to active this menu');
        return false;
    }
    if($(".nav-item."+className).length > 0){
        $(".nav-item."+className).addClass('active').siblings().removeClass('active');
        $(".nav-item."+className).parent().parent().addClass('active').siblings().removeClass('active');
        $(".nav-item."+className).parent().parent().find('span.arrow').addClass('open');
    }else{
        console.log('Class Name is not valid');
    }
}



var PagerModule = function (sortIndex, sortDirection) {
    var $scope = this;
    $scope.getDataCallback = function () {
        alert('hi');
    };
    $scope.currentPage = 1;
    $scope.pageSize = window.PageSize ? window.PageSize : 10;
    $scope.totalRecords = 0;
    $scope.sortIndex = sortIndex;
    $scope.sortDirection = sortDirection ? sortDirection : "ASC";
    $scope.pageChanged = function (newPage) {
        $scope.currentPage = newPage;
        $scope.getDataCallback();
    };

    $scope.TotalPages = function() {
        return parseInt($scope.totalRecords / $scope.pageSize) + 1;
    };

    //----------------------------------------- CODE FOR SORT-------------------------------------------
    //$scope.predicate = predicate; // coulumn name

    $scope.reverse = $scope.sortDirection != "ASC"; // false; // asc and desc
    $scope.sortColumn = function (newPredicate) {
        $scope.reverse = ($scope.sortIndex === newPredicate) ? !$scope.reverse : false;
        $scope.predicate = newPredicate;
        $scope.sortIndex = newPredicate != undefined ? newPredicate : sortIndex;
        $scope.sortDirection = $scope.reverse === true ? "DESC" : "ASC";
        $scope.getDataCallback();
    }


    //-----------------------------------------End CODE FOR SORT-------------------------------------------
};


