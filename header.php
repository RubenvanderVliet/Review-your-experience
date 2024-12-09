<div class="header">
    <div class="container-fluid">
        <div class="row bg-primary p-4 fixed-top"> <!-- Bovenste rij met een vaste positie -->
            <div class="col-2 d-flex justify-content-start align-items-center">
                <h2 class="text-white">TechOne</h2> <!-- Logo of titel van de website -->
            </div>
            <div class="col-9"> <!-- Hoofd gedeelte van de navigatie -->
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <!-- Knop voor het in- en uitklappen van de navigatie op kleinere schermen -->
                        <button class="navbar-toggler ms-auto bg-white text-white" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span> <!-- Icon voor de toggle knop -->
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav"> <!-- Inhoud van de navigatie -->
                            <ul class="navbar-nav d-flex justify-content-around align-items-center w-100"> <!-- Navigatielijst -->
                                <li class="nav-item fs-6 mt-2">
                                    <a class="nav-link text-opacity-100 text-white" aria-current="page"
                                       href="index.php">HOME</a> <!-- Link naar de startpagina -->
                                </li>
                                <li class="nav-item fs-6 mt-2">
                                    <a class="nav-link text-opacity-100 text-white" aria-current="page"
                                       href="master.php">CATEGORY</a> <!-- Link naar de categoriepagina -->
                                </li>
                                <div class="dropdown"> <!-- Dropdown menu voor producten -->
                                    <button class="btn nav-item fs-6 mt-2 nav-link text-white" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        PRODUCTS PAGE <!-- Titel van het dropdown menu -->
                                    </button>
                                    <ul class="dropdown-menu"> <!-- Lijst van dropdown items -->
                                        <li><a class="dropdown-item" href="#">Hardware</a></li> <!-- Link naar hardware -->
                                        <li><a class="dropdown-item" href="#">Pre-built</a></li> <!-- Link naar pre-built producten -->
                                        <li><a class="dropdown-item" href="#">Something else here</a></li> <!-- Extra item -->
                                    </ul>
                                </div>
                                <li class="nav-item fs-6 mt-2">
                                    <a class="nav-link text-opacity-100 text-white" href="contact-page.php">CONTACT
                                        PAGE</a> <!-- Link naar de contactpagina -->
                                </li>
                                <li class="nav-item fs-6 mt-2">
                                    <a class="nav-link text-opacity-100 text-white" href="login-register.php">LOGIN / REGISTER</a> <!-- Link naar inloggen / registreren -->
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col d-flex justify-content-center align-items-center">
                <!-- Winkelwagentje icoon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-bag text-white bg-primary" viewBox="0 0 16 16">
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                </svg>
            </div>
        </div>
    </div>
</div>
