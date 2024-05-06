<?php
session_start();
include('assets/config/config.php');
include('assets/config/checklogin.php');
check_login();
//generate random category code
$length = 3;
$Number =  substr(str_shuffle('QWERTYUIOPLKJHGFDSAZXCVBNM'), 1, $length);

//create a book category
if (isset($_POST['add_category'])) {
    $error = 0;
    // if (isset($_POST['code']) && !empty($_POST['code'])) {
    //     $tc_code = mysqli_real_escape_string($mysqli, trim($_POST['code']));
    // } else {
    //     $error = 1;
    //     $err = "Treaty Category number cannot be empty";
    // }
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $tc_name = mysqli_real_escape_string($mysqli, trim($_POST['name']));
    } else {
        $error = 1;
        $err = "Treaty Category name cannot be empty";
    }
    if (isset($_POST['desc']) && !empty($_POST['desc'])) {
        $tc_name = mysqli_real_escape_string($mysqli, trim($_POST['desc']));
    } else {
        $error = 1;
        $err = "Treaty Category description cannot be empty";
    }

    if (!$error) {
        $sql = "SELECT * FROM tbl_treatiescategory WHERE code='$tc_code' ";
        $res = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($tc_code == $row['code']) {
                $err =  "Treaty category code already exists";
            } else {
                $err =  "Treaty category code already exists";
            }
        } else {
            $tc_code = $_POST['code'];
            $tc_name = $_POST['name'];
            $tc_desc = $_POST['desc'];

            //Insert Captured information to a database table
            $query = "INSERT INTO tbl_treatiescategory (code, name, description) VALUES (?,?,?)";
            $stmt = $mysqli->prepare($query);
            //bind parameters
            $rc = $stmt->bind_param('sss', $tc_code, $tc_name, $tc_desc);
            $stmt->execute();

            //declare a varible which will be passed to alert function
            if ($stmt) {
                $success = "Treaty Category Added";
            } else {
                $err = "Please Try Again Or Try Later";
            }
        }
    }
}
?>

<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en"> <!--<![endif]-->
<?php
include("assets/inc/head.php");
?>

<body class="disable_transitions sidebar_main_open sidebar_main_swipe">
    <!-- main header -->
    <?php
    include("assets/inc/nav.php");
    ?>
    <!-- main header end -->
    <!-- main sidebar -->
    <?php
    include("assets/inc/sidebar.php");
    ?>
    <!-- main sidebar end -->

    <div id="page_content">
        <!--Breadcrums-->
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="pages_sudo_dashboard.php">Dashboard</a></li>
                <li><span>Manage Treaty Category</span></li>
            </ul>
        </div>

        <div id="page_content_inner">

            <div class="md-card">
                <div class="md-card-content">
                    <h3 class="heading_a">Please Fill All Fields</h3>
                    <hr>
                    <form method="post">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-2-2">
                                <div class="uk-form-row">
                                    <label>Category Name</label>
                                    <input type="text" name="name" class="md-input" />
                                </div>
                                <div class="uk-form-row">
                                    <label>Category Code</label>
                                    <input type="text" readonly value="FMOJ-<?php echo $Number; ?>" name="code" class="md-input label-fixed" />
                                </div>

                            </div>

                            <div class="uk-width-medium-2-2">
                                <div class="uk-form-row">
                                    <label>Category Description</label>
                                    <textarea cols="30" rows="4" class="md-input" name="desc"></textarea>
                                </div>
                            </div>
                            <div class="uk-width-medium-2-2">
                                <div class="uk-form-row">
                                    <div class="uk-input-group">
                                        <input type="submit" class="md-btn md-btn-success" name="add_category" value="Create Category" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!--Footer-->
    <?php require_once('assets/inc/footer.php'); ?>
    <!--Footer-->

    <!-- google web fonts -->
    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>

</body>

</html>