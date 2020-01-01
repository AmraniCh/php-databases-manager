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
      <li>Users (5)</li>
    </ul>
    <div class="clearfix"></div>
  </div>
  <!-- END FILTER PANEl -->

  <!-- START SIDEBAR ITEMS -->
  <div class="sidebar-databases-items">


  </div>
  <!-- END SIDEBAR ITEMS -->

  <!-- SIDEBAR LOADER -->
  <div class="loader-sidebar hide"></div>
  <!-- SIDEBAR LOADER -->

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

        <!-- <h1 class="no-selected text-center">no user selected</h1> -->

        <?php include "componenets/sectionHeader_permissions.html"; ?>

        <?php include "componenets/datatables/tablePermissions.html" ?>

      </div>
    <!-- END SECTION CONTAINER -->

    <?php include "componenets/modals/addUserModal.html" ?>
    <?php include "componenets/modals/deleteUserModal.html" ?>

  </div>
  <!-- END INNER CONTAINER -->

  <!-- START FOOTER -->
  <div class="footer shadow-top">
    <span class="copyrights">Databases Manager Copyrights 2020 <i class="mdi mdi-copyright"></i></span>
  </div>
  <!-- END FOOTER -->
</div>
<!-- END FULL CONTAINER -->
