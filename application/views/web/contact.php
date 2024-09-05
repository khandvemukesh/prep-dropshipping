<?php include 'php-assets/website-header.php'; ?>

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
  <?php include 'php-assets/website-nav.php'; ?>
  <section class="py-0 bg-light-gradient">
    <div class="bg-holder" style="background-image:url(<?php echo website_assets_url() ?>assets/img/illustrations/hero-bg.png);background-position:top right;background-size:contain;">
    </div>
    <!--/.bg-holder-->

    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-5 order-md-1 pt-8"><img class="img-fluid" src="<?php echo website_assets_url() ?>assets/img/gallery/feature-3.png" alt="" /></div>
        <div class="col-md-7 col-lg-6 text-center text-md-start pt-5 pt-md-9">
          <h1 class="display-2 fw-bold fs-4 fs-md-5 fs-xl-6">Contact Us</h1>
          <p class="mt-3 mb-4">We Are Fastest Growing Company In Chicago.</p>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <!-- Contact 1 - Bootstrap Brain Component -->
  <section class="bg-light py-3 py-md-5">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
          <h2 class="mb-4 display-5 text-center">Contact</h2>
          <p class="text-dark mb-5 text-center">The best way to contact us is to use our contact form below. Please fill out all of the required fields and we will get back to you as soon as possible.</p>
          <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row justify-content-lg-center">
        <div class="col-12 col-lg-9">
          <div class="bg-white border rounded shadow-sm overflow-hidden">

            <form action="#!">
              <div class="row gy-4 gy-xl-5 p-4 p-xl-5">
                <div class="col-12">
                  <label for="fullname" class="form-label">Full Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="fullname" name="fullname" value="" required>
                </div>
                <div class="col-12 col-md-6">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                      </svg>
                    </span>
                    <input type="email" class="form-control" id="email" name="email" value="" required>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <label for="phone" class="form-label">Phone Number</label>
                  <div class="input-group">
                    <span class="input-group-text">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                      </svg>
                    </span>
                    <input type="tel" class="form-control" id="phone" name="phone" value="">
                  </div>
                </div>
                <div class="col-12">
                  <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                  </div>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->




  <section class="bg-100 pb-0">
    <div class="container">
      <div class="row flex-center">
        <div class="col-xl-5 text-center mb-5 z-index-1">
          <h1 class="display-3 fw-bold fs-4 fs-md-6">Supported by real people</h1>
          <p>Our team of Happiness Engineers works remotely from 58 countries providing customer support across multiple time zones.</p>
        </div>
      </div>
    </div>
    <div class="position-relative text-center">
      <div class="bg-holder" style="background-image:url(undefined);background:url(assets/img/gallery/people-bg-shape.png) no-repeat center bottom, url(assets/img/gallery/people-bg-dot.png) no-repeat center bottom;">
      </div>
      <!--/.bg-holder-->
      <img class="img-fluid position-relative z-index-1" src="<?php echo website_assets_url() ?>assets/img/gallery/people.png" alt="" />
    </div>
  </section>
  <section class="py-0">
    <div class="bg-holder z-index-2" style="background-image:url(assets/img/illustrations/cta-bg.png);background-position:bottom right;background-size:61px 60px;margin-top:15px;margin-right:15px;margin-left:-58px;">
    </div>
    <!--/.bg-holder-->

    <div class="container-fluid px-0">
      <div class="card py-4 border-0 rounded-0 bg-primary">
        <div class="card-body">
          <div class="row flex-center">
            <div class="col-xl-9 d-flex justify-content-center mb-3 mb-xl-0">
              <h2 class="text-light fw-bold">Top Dropshipping Suppliers for Original US Products<br /></h2>
            </div>
            <div class="col-xl-3 text-center"><a class="btn btn-lg btnColor text-white btn-outline-light rounded-pill" href="#">GET STARTED</a></div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <?php include 'php-assets/website-footer.php'; ?>