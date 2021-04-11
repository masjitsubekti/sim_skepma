<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Sistem Informasi SKEPMA">
    <meta name="keywords" content="Sistem Informasi SKEPMA">
    <meta name="author" content="Masjit Subekti">
    <title><?= $title ?></title>
    <link rel="apple-touch-icon" href="<?php echo base_url() ?>/themes/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url() ?>/themes/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/vendors/css/vendors.min.css">
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/css/themes/semi-dark-layout.css">
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/css/pages/authentication.css">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/themes/app-assets/css/plugins/extensions/toastr.css">
    <style>
        .error-validasi {
            color: red;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu-modern 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <div id="app" class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-11 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                                    <img src="<?php echo base_url() ?>/themes/app-assets/images/pages/login.png" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Login</h4>
                                            </div>
                                        </div>
                                        <p class="px-2">Welcome back, please login to your account.</p>
                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                <form>
                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" @keypress.enter.prevent="auth()" v-model.trim="username" name="username" placeholder="Username" required>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>
                                                        <label for="user-name">Username</label>
                                                        <div class="error-validasi" v-if="!$v.username.isRequired"><small>Username wajib diisi !</small></div>
                                                    </fieldset>

                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input type="password" class="form-control" @keypress.enter.prevent="auth()" v-model.trim="password" name="password" placeholder="Password" required>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock"></i>
                                                        </div>
                                                        <label for="user-password">Password</label>
                                                        <div class="error-validasi" v-if="!$v.password.isRequired"><small>Password wajib diisi !</small></div>
                                                    </fieldset>
                                                    <div class="form-group d-flex justify-content-between align-items-center">
                                                        <div class="text-left">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <input type="checkbox">
                                                                    <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span class="">Remember me</span>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="text-right"><a href="auth-forgot-password.html" class="card-link">Forgot Password?</a></div>
                                                    </div>
                                                    <a href="javascript:;" class="btn btn-outline-primary float-left btn-inline">Register</a>
                                                    <button type="submit" class="btn btn-primary float-right btn-inline" @click.prevent="auth()" :disabled="(isLoading==true) ? true: false">
                                                        <i :class="(isLoading==true) ? 'fa fa-spin fa-spinner': ''"></i> Login
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="login-footer">
                                            <div class="divider">
                                                <div class="divider-text">OR</div>
                                            </div>
                                            <div class="footer-btn d-inline">
                                                <a href="#" class="btn btn-facebook"><span class="fa fa-facebook"></span></a>
                                                <a href="#" class="btn btn-twitter white"><span class="fa fa-twitter"></span></a>
                                                <a href="#" class="btn btn-google"><span class="fa fa-google"></span></a>
                                                <a href="#" class="btn btn-github"><span class="fa fa-github-alt"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo base_url() ?>/themes/app-assets/vendors/js/vendors.min.js"></script>
    <script src="<?php echo base_url() ?>/themes/app-assets/js/core/libraries/jquery.min.js"></script>
    <!-- BEGIN: Theme JS-->
    <script src="<?php echo base_url() ?>/themes/app-assets/js/core/app-menu.js"></script>
    <script src="<?php echo base_url() ?>/themes/app-assets/js/core/app.js"></script>
    <script src="<?php echo base_url() ?>/themes/app-assets/js/scripts/components.js"></script>
    <!-- Toast -->
    <script src="<?php echo base_url() ?>/themes/app-assets/vendors/js/extensions/toastr.min.js"></script>
    <!-- <script src="<?php echo base_url() ?>/themes/app-assets/js/scripts/extensions/toastr.js"></script> -->
    <script src="<?php echo base_url() ?>/all/vue/vue.js"></script>
    <script src="<?php echo base_url() ?>/all/axios/axios.min.js"></script>
    <script src="<?php echo base_url() ?>/all/vuelidate/vuelidate.min.js"></script>
    <script src="<?php echo base_url() ?>/all/vuelidate/validators.min.js"></script>
</body>

</html>
<script>
    const site_url = "<?= site_url() ?>";
    const base_url = "<?= base_url() ?>";

    Vue.use(window.vuelidate.default)
    new Vue({
        el: '#app',
        data: {
            username: '',
            password: '',
            isLoading: false
        },
        validations: {
            username: {
                isRequired: validators.required
            },
            password: {
                isRequired: validators.required
            },
        },
        created() {
            // this.load_data()
        },
        methods: {
            load_data: function(params) {
                //   console.log("Hello Word")
                // this.$v.$reset()
            },

            auth: function(event) {
                const self = this;
                self.$v.username.$touch();
                self.$v.password.$touch();
                if (self.$v.username.$invalid || self.$v.password.$invalid) {
                    console.log('error form invalid')
                } else {
                    if (self.isLoading == false) {
                        toastr.clear();
                        self.isLoading = true;
                        var formdata = new FormData();
                        formdata.append('username', self.username);
                        formdata.append('password', self.password);
                        axios({
                                method: 'post',
                                url: site_url + '/check_auth',
                                data: formdata,
                            })
                            .then(function(response) {
                                if (response.data.success == true) {
                                    setTimeout(function() {
                                        toastr.success(response.data.message, 'Berhasil', {
                                            "closeButton": true,
                                            "timeOut": 2000
                                        });
                                        setTimeout(function() {
                                            self.isLoading = false;
                                            window.location.href = site_url + '/beranda';
                                        }, 1500);
                                    }, 1000);
                                } else {
                                    setTimeout(function() {
                                        toastr.warning(response.data.message, 'Maaf', {
                                            "closeButton": true,
                                            "timeOut": 2500
                                        });
                                        self.isLoading = false;
                                    }, 1000);
                                }
                            })
                            .catch((err) => {
                                toastr.error(response.data.message, 'Maaf', {
                                    "closeButton": true,
                                    "timeOut": 2000
                                });
                            })
                    }

                }

            }
        }
    })
</script>