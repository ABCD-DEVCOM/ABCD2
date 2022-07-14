    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
          <span>Menu</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle" class="align-text-bottom"></span>
          </a>
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
              <span data-feather="home" class="align-text-bottom"></span>
              <?php echo $msgstr["userstatus"];?>
            </a>
          </li>
        <ul class="nav flex-column">

          <li class="nav-item">
            <a class="nav-link" href="#loans">
              <span data-feather="file" class="align-text-bottom"></span>
              <?php echo $msgstr["actualloans"]; ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="#reserves">
              <span data-feather="shopping-cart" class="align-text-bottom"></span>
              <?php echo $msgstr["actualreserves"]; ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#fines">
              <span data-feather="users" class="align-text-bottom"></span>
              <?php echo $msgstr["fines"];?> 
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#suspensions">
              <span data-feather="bar-chart-2" class="align-text-bottom"></span>
              <?php echo $msgstr["activesuspensions"];?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="layers" class="align-text-bottom"></span>
              Favorites
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/opac" target="_blank">
              <span data-feather="home" class="align-text-bottom"></span>
              Search the collection
            </a>
          </li>
        </ul>

      </div>
    </nav>