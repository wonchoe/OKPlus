<html>
    <head>
        <title>OKPlus :: Code Editor</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <script src="/lib/npm/codemirror/lib/codemirror.js"></script>
        <script src="/lib/npm/codemirror/addon/lint/lint.js"></script>
        <link rel="stylesheet" href="/lib/npm/codemirror/lib/codemirror.css">
        <link rel="stylesheet" href="/lib/npm/codemirror/addon/lint/lint.css">
        <script src="/lib/npm/codemirror/addon/lint/lint.js"></script>
        <script src="/lib/npm/codemirror/addon/lint/javascript-lint.js"></script>
        <script src="/lib/npm/codemirror/addon/lint/json-lint.js"></script>
        <script src="/lib/npm/codemirror/addon/lint/css-lint.js"></script>
        <script src="https://unpkg.com/jshint@2.9.6/dist/jshint.js"></script>
        <script src="https://unpkg.com/jsonlint@1.6.3/web/jsonlint.js"></script>
        <script src="https://unpkg.com/csslint@1.0.5/dist/csslint.js"></script>        
        <script src="/lib/npm/codemirror/mode/javascript/javascript.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="/styles/style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- bootstrap-css -->
        <link rel="stylesheet" href="/template/css/bootstrap.min.css">
        <!-- //bootstrap-css -->
        <!-- Custom CSS -->
        <link href="/template/css/style.css" rel="stylesheet" type="text/css">
        <link href="/template/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" href="/template/css/morris.css">
        <!-- font CSS -->
        <link href="//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css">
        <!-- font-awesome icons -->
        <link rel="stylesheet" href="/template/css/font.css" type="text/css">
        <link href="/template/css/font-awesome.css" rel="stylesheet"> 
        <!-- //font-awesome icons -->
        <script src="/template/js/jquery2.0.3.min.js"></script>
        <!-- charts -->
        <script src="/template/js/raphael-min.js"></script>
        <script src="/template/js/morris.js"></script>
        <!-- //charts -->
    </head>

    <body>
        <div class="loader-wrapper" id="loader-1">
            <div id="loader"></div>
        </div>

        <div id="saveStatus" class="alert alert-success"></div>
        <section id="container">
            <!--header start-->
            <header class="header fixed-top clearfix">
                <!--logo start-->
                <div class="brand">
                    <a href="/" class="logo">
                        OKPlus
                    </a>
                    <div class="sidebar-toggle-box">
                        <div class="fa fa-bars"></div>
                    </div>
                </div>
                <!--logo end-->


                <div class="top-nav clearfix">
                    <!--search & user info start-->
                    <ul class="nav pull-right top-menu">

                        <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" id="dropdownCustom" href="#" aria-expanded="false">

                                <span class="username"><?php echo ucfirst($username);?></span>

                            </a>
                            <ul class="dropdown-menu extended logout">


                                <li><a id="logout" href="/"><i class="fa fa-key"></i> Log Out</a></li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->

                    </ul>
                    <!--search & user info end-->
                </div>
            </header>
            <!--header end-->
            <!--sidebar start-->
            <aside>
                <?php include(ROOT . '/app/views/common/aside.php'); ?>
            </aside>
            <!--sidebar end-->
            <!--main content start-->
            <section id="main-content" class="">
                <section class="wrapper">

                    <div class="market-updates">
                        <div class="col-md-3 market-update-gd">
                            <div class="market-update-block clr-block-2">
                                <div class="col-md-4 market-update-right">
                                    <i class="fa fa-file"> </i>
                                </div>
                                <div class="col-md-8 market-update-left">
                                    <h4>File Size</h4>
                                    <h3><span id="fileSize">0</span> KB</h3>
                                    <p>Original</p>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <div class="col-md-3 market-update-gd">
                            <div class="market-update-block clr-block-1">
                                <div class="col-md-4 market-update-right">
                                    <i class="fa fa-compress"></i>
                                </div>
                                <div class="col-md-8 market-update-left">
                                    <h4>File Size</h4>
                                    <h3><span id="fileSizeCompressed">0</span> KB</h3>
                                    <p>Compressed file size</p>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <div class="col-md-3 market-update-gd">
                            <div class="market-update-block clr-block-3">
                                <div class="col-md-4 market-update-right">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <div class="col-md-8 market-update-left">
                                    <h4>Last modified</h4>
                                    <h3><span id="lastModifiedTime">0</span></h3>
                                    <p><span id="lastModifiedDate">0</span></p>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <div class="col-md-3 market-update-gd">
                            <div class="market-update-block clr-block-4">
                                <div class="col-md-4 market-update-right">
                                    <i class="fa fa-wpforms" aria-hidden="true"></i>
                                </div>
                                <div class="col-md-8 market-update-left">
                                    <h4>Lines count</h4>
                                    <h3><span id="lineCount">0</span></h3>
                                    <p></p>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>

                    <div class="table-agile-info">
                        <form>
                            <textarea id="codeEditor" name="codeEditor"></textarea>                
                        </form>                         
                        <div class="container-full">
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" id="saveButton" class="btn btn-primary btnMargin">Save code</button>
                                </div>
                            </div>
                        </div> 
                    </div>
                </section>



            </section>

            <!--main content end-->
        </section>
        <script src="/template/js/bootstrap.js"></script>
        <script src="/template/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="/template/js/jquery.slimscroll.js"></script>
        <script src="/template/js/jquery.nicescroll.js"></script>
        <script src="/template/js/codeeditor.js"></script>
        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="/template/js/flot-chart/excanvas.min.js"></script><![endif]-->


    </body></html>