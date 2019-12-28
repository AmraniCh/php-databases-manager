<!-- STRAT HEADER -->
<div class="header shadow-btm black">
  <a href="#" class="anchor">
    <div class="header-brand float-lt text-center blue">
      <span class="heading">databases mng</span>
    </div>
  </a>
  <div class="traingle-right float-lt"></div>
  <div class="header-items float-rt">
    <ul class="header-menu list-unstyled list-inline">
      <li>
        <div class="cercle-badge" data-toggle="success">
          <div data-value="success" class="popup blue">
            <span class="triangle-top"></span>
            <div class="popup-content text-center">
              connection to MySql server is ok
            </div>
          </div>
          <div data-value="error" class="popup blue">
            <span class="triangle-top"></span>
            <div class="popup-content text-center">
              error connection MySQL
            </div>
          </div>
        </div>
      </li>
      <li>
        <span class="username">Username</span>
      </li>
      <li>
        <button id="settings-btn" type="button" class="btn settings-btn blue">
          <i class="mdi mdi-settings"></i>
        </button>
        <div class="settings-menu">
          <ul class="list-unstyled">
            <li>
              <button id="settings-page" type="button" class="btn">
                <i class="mdi mdi-settings"></i>
                <span>settings</span>
              </button>
            </li>
            <li>
              <button id="permissions-page" type="button" class="btn">
                <i class="mdi mdi-lock"></i>
                <span>permissions</span>
              </button>
            </li>
            <li>
              <button id="logout-btn" type="button" class="btn">
                <i class="mdi mdi-logout"></i>
                <span>logout</span>
              </button>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>
<!-- END HEADER -->

<!-- START SIDEBAR -->
<div class="sidebar">

  <!-- FILTER PANEl -->
  <div class="filter-panel panel-item green" data-toggle="open">
    <ul class="list-unstyled list-inline float-lt">
      <li>
        <button type="button" class="btn hide" data-value="open">
          <i class="icon-big mdi mdi-arrow-up-drop-circle"></i>
        </button>
        <button type="button" class="btn hide" data-value="close">
          <i class="icon-big mdi mdi-arrow-down-drop-circle"></i>
        </button>
      </li>
      <li>Databases (10)</li>
    </ul>
    <button id="filter-button" type="button" class="btn float-rt focus">
      <i class="icon-big mdi mdi-filter"></i>
    </button>
    <div class="clearfix"></div>
  </div>
  <!-- END FILTER PANEl -->

  <!-- START SIDEBAR ITEMS -->
  <div class="sidebar-databases-items">


  </div>
  <!-- END SIDEBAR ITEMS -->
</div>
<!-- END SIDEBAR -->

<!-- START FULL CONTAINER -->
<div class="full-container">
  <div class="loader-straight hide">
    <div class="loader-content">
    </div>
  </div>

  <!-- START INNER CONTAINER -->
  <div class="inner-container">

    <!-- START SECTION CONTAINER -->
      <div id="ajx-content" class="section-container text-color">

        <h1 class="no-selected text-center">no database table selected</h1>

      </div>
    <!-- END SECTION CONTAINER -->

  </div>
  <!-- END INNER CONTAINER -->

  <!-- START FOOTER -->
  <div class="footer shadow-top">
    <span class="copyrights">Databases Manager Copyrights 2020 <i class="mdi mdi-copyright"></i></span>
  </div>
  <!-- END FOOTER -->
</div>
<!-- END FULL CONTAINER -->
