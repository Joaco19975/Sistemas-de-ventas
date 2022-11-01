   
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/structure.css') }}" rel="stylesheet" type="text/css" class="structure" />

    <link href="{{ asset('plugins/font-icons/fontawesome/css/fontawesome.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/css/elements/avatar.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="{{ asset('assets/css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
     <link rel="stylesheet" href="{{ asset('assets/css/apps/scrumboard.css')}}" type="text/css">
     <link rel="stylesheet" href="{{ asset('assets/css/apps/notes.css')}}" type="text/css">

    
   


   <!-- <link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">-->
   <!-- <link href="{{ asset('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />-->
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

     <style>
      /*La etiqueta <aside> está diseñado para contener información adicional al documento que se visualiza. */ 
          aside{
                display:none!important;
           }

           .page-item.active .page-link {
               z-index: 3;
               color: #fff;
               background-color: #3b3f5c;
               border-color: #3b3f5c;
           }

           @media(max:width: 480px)
           {

                  .mtmobile {
                     margin-bottom: 20px!important;
                  }
                  .mtmobile {
                     margin-bottom: 10px!important;
                  }
                  .hideonsm {
                     display: none!important;
                  }
                  .inblock {
                     display:block;
                  }

           }

           .sidebar-theme #compactSidebar {
            background: #191e3a!important;
            
           }

           /*sidebar collapse background*/ 
           .header-container .sidebarCollapse {
             color: #3b3f5c!important;
            }

            .navbar .navbar-item .nav-item form.form-inline input.search-form-control {
                  font-size: 15px;
                  background-color: #3b3f5c!important;
                  padding-right: 40px;
                  padding-top: 12px;
                  border: none;
                  color: #fff;
                  box-shadow: none;
                  border-radius: 30px;
               }

     </style>

@livewireStyles