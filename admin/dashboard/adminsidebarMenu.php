<?php if (isset($_SESSION['userId'])) {  ?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="sidebar-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="#" onclick="load_contentadmin('Dashboard.php');">
          <span data-feather="home"></span>
          หน้าแรก <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" onclick="load_contentadmin('managesubject.php');">
          <span data-feather="file"></span>
          รายวิชา
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" onclick="load_contentadmin('managestu.php');">
          <span data-feather="file"></span>
          ข้อมูลนักเรียน
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" onclick="load_contentadmin('managecourse.php');">
          <span data-feather="file"></span>
          หลักสูตร
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" onclick="load_contentadmin('managecourseclass.php');">
          <span data-feather="file"></span>
          กลุ่มชั้นเรียน
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" onclick="load_contentadmin('manageg.php');">
          <span data-feather="file"></span>
          ผลการเรียน
        </a>
      </li>
    </ul>
  </div>
</nav>
<?php } ?>
<?php if (isset($_SESSION['student_id'])) {  ?>
  <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">
      <ul class="nav flex-column">

        <li class="nav-item">
          <a class="nav-link" href="#" onclick="load_contentadmin('managemyg.php');">
            <span data-feather="file"></span>
            ผลการเรียน
          </a>
        </li>
      </ul>
    </div>
  </nav>
<?php } ?>
