<?php session_start (); ?>
<!-- STRAT HEADER -->
<div class="header shadow-btm black">
  <a href="index.php" class="anchor">
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
        <span class="username"><?php if(isset($_SESSION['user'])) echo $_SESSION['user'] ?></span>
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
