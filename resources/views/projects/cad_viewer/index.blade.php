<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>CADViewer JS</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <meta name="generator" content="TMS" />
    <meta name="created" content="Thu, 10 April 2016 16:14:30 GMT" />
    <meta name="description" content="Tailor Made Software  - CADViewer JS Sample Page." />
    <meta name="keywords" content="" />

    <link href="{{ asset('css/cad_viewer/cvjs_69.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/cad_viewer/jquery.qtip.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/cad_viewer/bootstrap.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/cad_viewer/loading_animation_2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cad_viewer/jquery-ui-1.11.4.min.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/cad_viewer/layerlist_05.css') }}" media="screen" rel="stylesheet" type="text/css" />

</head>
<body bgcolor="white" style="margin:0" >


<table id="none">
    <tr>
        <td>
            <!--This is the CADViewer JS declaration, an SVG element with the canvas size, and a <div> cvjs_Modal, that is used for modals -->
            <svg id="floorPlan"  style="border:2px none; width:1800;height:1400;">
            </svg>
            <div id="cvjs_Modal"></div>
            <!--End of CADViewer JS declaration -->
        </td>
    </tr>
</table>


<script src="{{ asset('js/cad_viewer/jquery-2.2.3.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/cad_viewer/jquery.qtip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/cad_viewer/snap.svg-min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('js/cad_viewer/cadviewerjs.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('js/cad_viewer/cadviewerjs_setup.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('js/cad_viewer/axuploader_2_18.js') }}" type="text/javascript" ></script>
<script src="{{ asset('js/cad_viewer/cvjs_api_styles_2_0_22.js') }}" type="text/javascript" ></script>
<script type="text/javascript" src="{{ asset('js/cad_viewer/rgbcolor.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cad_viewer/StackBlur.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cad_viewer/canvg.js') }}"></script>
<script src="{{ asset('js/cad_viewer/jquery-ui-1.11.4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/cad_viewer/list.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/cad_viewer/jscolor.js') }}"></script>

<script type="text/javascript">


    var FileName = "http://steiger.error404.ro/img/temp2.dwg"; // PATH and FILE to be loaded

    $(document).ready(function()
    {

        // Sets the icon interface for viewing, layerhanding, measurement, etc. only
        cvjs_setIconInterfaceControls_ViewingOnly();

        // disable canvas interface.  For developers building their own interface
        // cvjs_setIconInterfaceControls_DisableIcons(true);

        cvjs_debugMode(true);

        cvjs_allowFileLoadToServer(false);
        cvjs_setPanState(true);

        // set the location to license key, typically ../javascripts
        cvjs_setLicenseKeyPath("{{ asset('js/cad_viewer/') }}/");



        // CHANGE LANGUAGE - DEFAULT IS ENGLISH
        // window.alert("Avaliable Languages: "+cvjs_getLanguages());
        // cvjs_setLanguage("Spanish");   // alternatively cvjs_setLanguage("ES-ES");
        // cvjs_setLanguage("Portuguese"); // alternatively cvjs_setLanguage("PT-PT");
        // cvjs_setLanguage("English");   // English is default  , alternatively cvjs_setLanguage("EN-US");
        // cvjs_setLanguage("Portuguese (Brazil)");   // English is default   alternatively cvjs_setLanguage("PT-BR");





        // NOTE BELOW: THESE SETTINGS ARE FOR SERVER CONTROLS FOR HANDLING OF PRINT OBJECTS and FILE OBJECTS
        // The default settings is using PHP in /php/ folder with controlling documents in /php/ folder and print objects in /php/temp_print
        // Using PHP or Servlets


        // DEFAULT SETTINGS FOR PHP

//      cvjs_setPhpPath("../php/");        // location of php handlers for file upload and modals, typically same path as cvjs_setServerHandlersPath(),
        // but can be separated in case of custom implementation of print handlers either as php or servlets
        // use an absolute path if using cvjs_setRedlinesAbsolutePath() and cvjs_setInsertImageObjectsAbsolutePath()

//		cvjs_setServerHandlersPath("../php/");          // location of print handlers, in the standard case this in the /php/ folder with redline and file controllers
//		cvjs_setPrintObjectPath("./temp_print/");      // location of print object relative to controller document
//		cvjs_setServerSaveFileHandler("save-file.php");	// name of server side save-file controller document
//		cvjs_setServerAppendFileHandler("append-file.php"); // name of server side append-file controller document
//		cvjs_setServerDeleteFileHandler("delete-file.php"); // name of server side delete-file controller docoment

        // SAMPLE SETTINGS FOR PHP - WHEN CLEANING UP PRINT OBJECTS AFTER PRINT
        cvjs_setServerHandlersPath("http://localhost/CV-JS_2_3_5/php/");    // location of print handlers, in the standard case this in the /php/ folder with redline and file controllers
        cvjs_removePrintObjectAfterPrint(true);
        cvjs_setJavaScriptsJQ_AbsoluteFolder("http://localhost/CV-JS_2_3_5/javascripts/jquery-2.2.3.js");



        // SAMPLE SETTINGS FOR SERVLETS - ALTERNATIVE TO DEFAULT PHP SETTING
//		cvjs_setServerHandlersPath("http://localhost:8080/CV-JS_2_3_5/servlets/servlet");          // location of print handlers, in the standard case this in the /php/ folder with redline and file controllers
        //cvjs_setPrintObjectPath("./temp_print/");      // location of print object relative to Controller
//		cvjs_setPrintObjectPathAbsolute("http://localhost:8080/CV-JS_2_3_5/temp_print/","C:\\xampp\\tomcat\\webapps\\CV-JS_2_3_5\\temp_print\\");      // absolute location of Print object, url and server
//		cvjs_setServerSaveFileHandlerPrint("SaveServlet");	// name of server side save-file controller document
//		cvjs_setServerAppendFileHandlerPrint("AppendServlet"); // name of server side append-file controller document
//		cvjs_setServerDeleteFileHandlerPrint("DeleteServlet"); // name of server side delete-file controller docoment

        // NOTE ABOVE: THESE SETTINGS ARE FOR SERVER CONTROLS FOR HANDLING OF PRINT OBJECTS and FILE OBJECTS




        // NOTE BELOW: THESE SETTINGS ARE FOR SERVER CONTROLS FOR UPLOAD OF REDLINES
        // Redlines folder location used when file-manager is used for upload and redline selection
        //cvjs_setRedlinesRelativePath('../redlines/demo/','C:\\xampp\\htdocs\\CV-JS_2_3_5\\redlines\\demo\\');
        //cvjs_setRedlinesAbsolutePath('http://localhost/CV-JS_2_3_5/redlines/demo/','C:\\xampp\\htdocs\\CV-JS_2_3_5\\redlines\\demo\\');



        // NOTE ABOVE: THESE SETTINGS ARE FOR SERVER CONTROLS FOR UPLOAD OF REDLINES


        // NOTE BELOW: THESE SETTINGS ARE FOR SERVER CONTROLS FOR UPLOAD OF FILES AND FILE MANAGER

        // I am setting the full path to the location of the floorplan drawings (typically  /home/myserver/drawings/floorplans/)
        // and the relative location of floorplans drawings relative to my current location
        // as well as the URL to the location of floorplan drawings with username and password if it is protected "" "" if not
        // cvjs_setServerFileLocation('C:\\xampp\\htdocs\\CV-JS_2_3_5\\drawings\\demo\\floorplans\\', '../drawings/demo/floorplans/', 'http://localhost/CV-JS_2_3_5/drawings/demo/floorplans/',"","");
        // cvjs_setServerFileLocation_AbsolutePaths('C:\\xampp\\htdocs\\CV-JS_2_3_5\\drawings\\demo\\floorplans\\', 'http://localhost/CV-JS_2_3_5/drawings/demo/floorplans/',"","");




        // NOTE ABOVE: THESE SETTINGS ARE FOR SERVER CONTROLS FOR UPLOAD OF FILES AND FILE MANAGER



        // NOTE BELOW: THESE SETTINGS ARE FOR SERVER CONTROLS FOR CONVERTING DWG, DXF, DWF files

        // I need to set variables to point to my server where I have installed AutoXchange and the controlling scripts,
        cvjs_setRestApiControllerLocation("http://creator.vizquery.com/cvjs_ax/");
        cvjs_setRestApiController("call-Api_08_ax2.php");


        // If I want to overwrite these values with settings for my own server where I have installed AutoXchange and the controlling scripts,
        //  I can control whem with the methods:
        //      cvjs_Init_ConversionServer(rest_api_url, rest_api_php, username, password);
        // or:  cvjs_setConverterCredentials(username, password);
        // or:  cvjs_setConverter(converter, version);

        // Now I want to set up the parameters for the conversion call, if I do not do anything, the conversion is set up to load FileNameUrl as a file (see RestAPI for other methods),
        // the resulting is located on the server as a stream. This means that CADViewer JS will read up the file and it is deleted on server after reading.
        // The conversion parameters are standard set-up from within AutoXchange:  -prec=2, -size=2800 -ml=0.4
        // When browsing through multiple layouts in a file, for each layout a new conversion will be triggered.


        // Now as an alternative, I want to set the content response to file instead of stream. This means that the server will keep a copy of the file (randomly named)
        // The pros is that I can quicker browse throught the multipages in the file
        // The cons is that loading of first page takes longer and that I need to clean up the server when I leave the page (or at the end of the day)
        // For this to work, I need to set the conversion parameter -basic, so that all pages in the set are converted initially

        // cvjs_conversion_setContentResponse("file");
        // cvjs_conversion_addAXconversionParameter("basic", "");

        // If the file that has to be converted is behind a password protection, set the username/password for picking up the DWG/DWF/DXF file
        // cvjs_setOriginatingFileUsernamePassword(username, password);


        // If I want to control the parameters controls in conversions I will call some of the following methods prior to conversion , see API documentation

        // I want to clear all pre-set autoxchange conversion parameters
        // cvjs_conversion_clearAXconversionParameters();
        // now I want to increase the size of the output drawing, this is useful for large drawings with much detail
        // cvjs_conversion_addAXconversionParameter("size", "4800");
        // now I want to make the minimum lines manually thinner, this is useful for large drawings with much detail, default is 0.6 but an automated process
        // autocorrect the thickness, using this parameter will overwrite this setting
        // cvjs_conversion_addAXconversionParameter("ml", "0.4");
        // I also make a slightly lower precision to make the resulting file smaller, the original drawing has a default of resolution space 2
        // cvjs_conversion_addAXconversionParameter("prec", "1");


        // For the server, I want to tell which path to the xrefs I want to use in this conversion, this is preset on the server to ./files/xref
        // cvjs_conversion_addAXconversionParameter("xpath", "/myserverlocation/files/xrefs2");

        // NOTE ABOVE: THESE SETTINGS ARE FOR SERVER CONTROLS FOR CONVERTING DWG, DXF, DWF files



        // Initialize CADViewer JS  - needs the div name on the svg element on page that contains CADViewerJS and the relative location of the images and javascripts folder
        // relative the (this) calling document
        cvjs_InitCADViewerJS("floorPlan", '{{ asset('img/cad_viewer/') }}/', '{{ asset('js/cad_viewer/') }}/');

        // Load file - needs the svg div name and name and path of file to load
        cvjs_LoadDrawing("floorPlan", FileName );


        cvjs_windowResize_position(false, "floorPlan" );

    });  // end ready()




    $(window).resize(function() {
        cvjs_windowResize_position(true, "floorPlan" );
    });


    /// NOTE: THESE METHODS BELOW ARE JS SCRIPT CALLBACK METHODS FROM CADVIEWER JS, THEY NEED TO BE IMPLEMENTED BUT CAN BE EMPTY


    function cvjs_OnLoadEnd(){
        // generic callback method, called when the drawing is loaded
        // here you fill in your stuff, call DB, set up arrays, etc..
        // this method MUST be retained as a dummy method! - if not implemeted -

        cvjs_resetZoomPan();

    }


    function cvjs_OnLoadEndRedlines(){
        // generic callback method, called when the redline is loaded
        // here you fill in your stuff, hide specific users and lock specific users
        // this method MUST be retained as a dummy method! - if not implemeted -


        cvjs_hideAllRedlines_HiddenUsersList();
        cvjs_lockAllRedlines_LockedUsersList();

    }


    // generic callback method, tells which FM object has been clicked
    function cvjs_change_space(){

    }

    function cvjs_graphicalObjectCreated(graphicalObject){

        // do something with the graphics object created!
//		window.alert(graphicalObject);

    }

    function cvjs_ObjectSelected(rmid){
        // placeholder for method in tms_cadviewerjs_modal_1_0_14.js   - must be removed when in creation mode and using creation modal
    }

    /// NOTE: THESE METHODS ABOVE ARE JS SCRIPT CALLBACK METHODS FROM CADVIEWER JS, THEY NEED TO BE IMPLEMENTED BUT CAN BE EMPTY


    /// NOTE: THESE METHODS BELOW ARE SIMPLE SAMPLE METHODS OF CADVIEWER JS API USING THE HTML INPUT AND BUTTONS DEFINED ON THIS PAGE


    // This method is linked to the save redline icon in the imagemap
    function cvjs_saveStickyNotesRedlinesUser(){

        // there are two modes, user handling of redlines
        // alternatively use the build in redline file manager
        // cvjs_openRedlineSaveModal();

        // custom method startMethodRed to set the name and location of redline to save
        // see implementation below
        startMethodRed();
        // API call to save stickynotes and redlines
        cvjs_saveStickyNotesRedlines();
    }


    // This method is linked to the load redline icon in the imagemap
    function cvjs_loadStickyNotesRedlinesUser(){

        // there are two modes, user handling of redlines
        // alternatively use the build in redline file manager
        // cvjs_openRedlineLoadModal();

        // first the drawing needs to be cleared of stickynotes and redlines
        //cvjs_deleteAllStickyNotes();
        //cvjs_deleteAllRedlines();

        // custom method startMethodRed to set the name and location of redline to load
        // see implementation below
        startMethodRed();

        // API call to load stickynotes and redlines
        cvjs_loadStickyNotesRedlines();
    }



    function startMethodRed(){

        var v1 = $('#load_redline_url').val();
        var v2 = $('#save_redline_url').val();

        cvjs_setStickyNoteRedlineUrl(v1);
        cvjs_setStickyNoteSaveRedlineUrl(v2);
    }


    function set_user_credentials(){

        var user_name = $('#user_name').val();
        var user_id = $('#user_id').val();
//	window.alert("Redline/StickyNote user settings: "+user_name+" "+user_id+" ");

        cvjs_setCurrentStickyNoteValues_NameUserId(user_name, user_id );
        cvjs_setCurrentRedlineValues_NameUserid(user_name, user_id);

    }



    function add_user_to_hide_list(){

        var user_hide = $('#user_hide').val();
        cvjs_addUserIdToHiddenRedlineUsers(user_hide);

    }


    function show_hidden_users_list(){

        window.alert(cvjs_getRedlineHiddenUsersList());

    }


    function clear_hidden_users_list(){

        cvjs_clearAllRedlineHiddenUsers();
    }




    function add_user_to_locked_list(){

        var user_hide = $('#user_lock').val();
        cvjs_addUserIdToLockedRedlineUsers(user_hide);

    }


    function show_locked_users_list(){

        window.alert(cvjs_getRedlineLockedUsersList());

    }


    function clear_locked_users_list(){

        cvjs_clearAllRedlineLockedUsers();
    }


    /// NOTE: THESE METHODS ABOVE ARE SIMPLE SAMPLE METHODS OF CADVIEWER JS API USING THE HTML INPUT AND BUTTONS DEFINED ON THIS PAGE

</script>



</body>
</html>
