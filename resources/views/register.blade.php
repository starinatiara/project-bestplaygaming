<!DOCTYPE html>
<html lang="en">

<head>
  <title>Register | PS Rental</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="description" content="PS Rental">
  <meta name="keywords" content="PS Rental, PlayStation Rental, Rental PS">
  <meta name="author" content="PS Rental">

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">

  <!-- Font -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}" id="main-font-link">

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
  <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
</head>

<body
  data-pc-preset="preset-1"
  data-pc-sidebar-caption="true"
  data-pc-layout="vertical"
  data-pc-direction="ltr"
  data-pc-theme_contrast=""
  data-pc-theme="light">

  <!-- Pre-loader -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="auth-main">
    <div class="auth-wrapper v1">
      <div class="auth-form">

        <div class="card my-5">
          <div class="card-body">

            <!-- Logo -->
            <div class="text-center">
              <a href="/login">
                <img src="{{ asset('assets/images/logo-dark.svg') }}" alt="PS Rental">
              </a>
            </div>

            <!-- Social Register -->
            <div class="d-grid my-3">

              <button type="button"
                class="btn mt-2 btn-light-primary bg-light text-muted">
                <img src="{{ asset('assets/images/authentication/facebook.svg') }}" alt="Facebook">
                <span>Sign Up with Facebook</span>
              </button>

              <button type="button"
                class="btn mt-2 btn-light-primary bg-light text-muted">
                <img src="{{ asset('assets/images/authentication/twitter.svg') }}" alt="Twitter">
                <span>Sign Up with Twitter</span>
              </button>

              <button type="button"
                class="btn mt-2 btn-light-primary bg-light text-muted">
                <img src="{{ asset('assets/images/authentication/google.svg') }}" alt="Google">
                <span>Sign Up with Google</span>
              </button>

            </div>

            <!-- Separator -->
            <div class="saprator my-3">
              <span>OR</span>
            </div>

            <!-- Title -->
            <h4 class="text-center f-w-500 mb-3">
              Sign up with your work email.
            </h4>

            <!-- First & Last Name -->
            <div class="row">

              <div class="col-sm-6">
                <div class="form-group mb-3">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="First Name">
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group mb-3">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Last Name">
                </div>
              </div>

            </div>

            <!-- Email -->
            <div class="form-group mb-3">
              <input
                type="email"
                class="form-control"
                placeholder="Email Address">
            </div>

            <!-- Password -->
            <div class="form-group mb-3">
              <input
                type="password"
                class="form-control"
                placeholder="Password">
            </div>

            <!-- Confirm Password -->
            <div class="form-group mb-3">
              <input
                type="password"
                class="form-control"
                placeholder="Confirm Password">
            </div>

            <!-- Terms -->
            <div class="d-flex mt-1 justify-content-between">

              <div class="form-check">

                <input
                  class="form-check-input input-primary"
                  type="checkbox"
                  id="customCheckc1"
                  checked>

                <label
                  class="form-check-label text-muted"
                  for="customCheckc1">
                  I agree to all the Terms & Condition
                </label>

              </div>

            </div>

            <!-- Register Button -->
            <div class="d-grid mt-4">
              <a
                href="/login"
                class="btn btn-primary">
                Sign up
              </a>
            </div>

            <!-- Back to Login -->
            <div class="d-flex justify-content-between align-items-end mt-4">

              <h6 class="f-w-500 mb-0">
                Already have an Account?
              </h6>

              <a
                href="/login"
                class="link-primary">
                Login
              </a>

            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Required Js -->
  <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

  <script>
    change_box_container('false');
    layout_caption_change('true');
    layout_rtl_change('false');
    preset_change("preset-1");
  </script>

</body>

</html>