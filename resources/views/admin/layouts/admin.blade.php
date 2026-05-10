@include('admin.include.adminHeader')
<!-- MAIN CONTENT -->
<main id="content" class="content py-10" style="padding-bottom: 0px !important;">
  <div class="container-fluid d-flex flex-column dashboard-container">
    <div class="dashboard-content-area flex-grow-1">
        @yield('content')
    </div>

    <div class="row dashboard-footer-row" style="background:lavender; margin-top: 20px;">
      <div class="col-12">
        <footer class="text-center py-2 mt-3 mb-2 text-secondary ">
          <p class="mb-0">Copyright © 2026 Lavender CMS. Developed by <a href="mailto:sarkarmeher1999@gmail.com"
              target="_blank" class="text-primary">Meher Kanti Sarkar</a> </p>
        </footer>
      </div>
    </div>
  </div>
</main>
@include('admin.include.adminFooter')