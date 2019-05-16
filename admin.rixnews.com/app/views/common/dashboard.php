<html>
    <head>
        <title>OKPlus :: Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="/styles/style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
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
                                <i class="fa fa-user"></i>
                                <span class="username"><?php echo ucfirst($username); ?></span>

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
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="col-md-8 market-update-left">
                                    <h4>Today</h4>
                                    <h3><span id="usersToday">0</span></h3>
                                    <p>total response</p>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <div class="col-md-3 market-update-gd">
                            <div class="market-update-block clr-block-1">
                                <div class="col-md-4 market-update-right">
                                    <i class="fa fa-users fa-user-silver"></i>
                                </div>
                                <div class="col-md-8 market-update-left">
                                    <h4>Yesterday</h4>
                                    <h3><span id="usersYesterday">0</span></h3>
                                    <p>total response</p>
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
                                    <h4>Last visit</h4>
                                    <h3><span id="lastVisitTime">00:00:00</span></h3>
                                    <p><span id="lastVisitDate">2019-05-15</span></p>                                    

                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <div class="col-md-3 market-update-gd">
                            <div class="market-update-block clr-block-4">
                                <div class="col-md-4 market-update-right">
                                    <i class="fa fa-globe" aria-hidden="true"></i>
                                </div>
                                <div class="col-md-8 market-update-left">
                                    <h4>Location</h4>
                                    <h3><span id="locationCountry">-</span></h3>
                                    <p><span id="locationCity">-</span></p>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>


                    <div class="row">
                        <div class="panel-body">
                            <div class="col-md-12 w3ls-graph">
                                <!--agileinfo-grap-->
                                <div class="agileinfo-grap">
                                    <div class="agileits-box">
                                        <header class="agileits-box-header clearfix">
                                            <h3>Visitor Statistics</h3>
                                            <div class="toolbar">
                                                <canvas id="totalChart"></canvas>

                                            </div>
                                        </header>
                                        <div class="agileits-box-body clearfix">
                                            <div id="hero-area" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--//agileinfo-grap-->

                            </div>
                        </div>
                    </div>     


                    <div class="table-agile-info">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Detail table
                            </div>
                            <div>
                                <table class="table" ui-jq="footable">
                                    <thead>
                                        <tr>
                                            <th data-breakpoints="xs">Date</th>
                                            <th>Total</th>
                                            <th>Chrome</th>
                                            <th data-breakpoints="xs">Yandex</th>
                                            <th data-breakpoints="xs sm md">Amigo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">

                                    </tbody>
                                </table>
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
        <script src="/template/js/dashboard.js"></script>
        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="/template/js/flot-chart/excanvas.min.js"></script><![endif]-->


    </body></html>