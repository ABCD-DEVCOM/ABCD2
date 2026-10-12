<br />
<p align="center">
  <a href="https://abcd-community.org/" target="_blank">
    <img width="400" alt="LOGO_ABCD_GERAL2023" src="https://github.com/user-attachments/assets/10e87e71-606d-4647-9fe5-54dc8fe463bf" />
  </a>

  <h3 align="center">ABCD: Library Services Platform based on CISIS</h3>

  <p align="center">
    Welcome to the development of the ABCD!
    <br />
    <a href="https://abcd-devcom.github.io/" target="_blank"><strong>Explore the ABCD Knowledge Base »</strong></a>
    <br />
    <br />
    <a href="https://demo.abcd-community.org/" target="_blank">View Demo</a>
    ·
    <a href="https://github.com/ABCD-DEVCOM/ABCD/issues">Report Bug</a>
    ·
    <a href="https://github.com/ABCD-DEVCOM/ABCD/issues">Request Feature</a>
  </p>
</p>

<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#key-features">Key Features</a></li>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->
## About The Project

<img width="800" alt="Central Module" src="https://github.com/user-attachments/assets/ded39ba3-eebc-43c6-90ec-60e87c7b423e" />

The acronym **ABCD** stands for:

> **A**utomatización de **B**ibliotecas y **C**entros de **D**ocumentación<br>
> **A**utomation des **B**ibliothèques et **C**entres de **D**ocumentacion<br>
> **A**utomatização das **B**ibliotecas e dos **C**entros de **D**ocumentação<br>
> **A**utomeatisering van **B**ibliotheken en **C**entra voor **D**ocumentatie

ABCD was initially developed by BIREME with the support of VLIR/UOS and based on UNESCO-supported ISIS-technology. Following BIREME's departure from the project, ABCD is now solely maintained, updated, and evolved by the global open-source community. Special historical thanks are given to G. Ascencio and E. Spinak for their foundational roles.

### The Evolution: From ILS to LSP

While ABCD started as a traditional Integrated Library System (ILS), it has evolved into a modern, highly interoperable **Library Services Platform (LSP)**. Flexibility and versatility remain at the forefront of our development. The software is capable of managing virtually any bibliographic or textual structure—including archives and museum collections—powered by the robust underlying CISIS textual database technology.

Recent versions have streamlined the architecture into a cohesive, native environment, eliminating legacy dependencies and introducing a modern ecosystem:

<img width="1000" alt="image" src="https://github.com/user-attachments/assets/b49dc58b-9f08-43e4-adba-ab9c2ce39c80" />


### Key Features

* **Plugin-Based Modular Architecture:** The core system is lightweight. Specific modules and legacy apps (like ODDS, SIP2, etc.) are now installable on demand via our new remote plugin manager.
* **Native REST API & Interoperability:** A secure, built-in REST API with SHA256 encryption handles direct database access, JSON batch exports, and native mapping to Dublin Core and MARC standards.
* **Multidisciplinary Support:** Beyond traditional libraries, ABCD now offers dedicated data models and OPAC displays for Museum management based on the international SPECTRUM standard.
* **Advanced Public Catalog (OPAC):** Features an Expert Boolean Search, configurable relevance ranking, collapsible results panels, and robust performance for large datasets.
* **Modern Administration:** Features a cascading translation system (`LanguageManager`) to protect local customizations, improved data entry fields (like cryptographic `HASH` and secure auto-increment workflows), and CSRF-protected interfaces.

### Built With

ABCD is written and maintained using the following core technologies:
* [PHP](https://www.php.net/)
* [CISIS](https://github.com/ABCD-DEVCOM/ABCD) (Legacy core engine discontinued by BIREME, now actively maintained and developed by the ABCD Community)
* [HTML](https://en.wikipedia.org/wiki/HTML)
* [JavaScript](https://en.wikipedia.org/wiki/JavaScript)

<!-- DOWNLOAD and Install -->
## Installation

ABCD is supported on **Windows** and **Linux**  
[Download the latest ABCD release](https://abcd-community.org/dowloads/)  
[Download all code from GitHub ABCD-DEVCOM / ABCD](https://github.com/ABCD-DEVCOM/ABCD)

Installation prerequisites and installation procedures vary by version.
See the [Installation folder](https://github.com/ABCD-DEVCOM/ABCD/tree/master/zz_installation) for detailed instructions and material.
Note that the ABCD downloads do not include third-party software prerequisites.

<!-- USAGE EXAMPLES -->
## Usage

You can try the ABCD software on an online installation. All features that you can access come with the default installation package of ABCD.

Our demo version is synchronized with the development in the Github repository, so there may be some bugs. We will soon make a more stable demo version available in parallel with development for comparison.

**Instructions:**
To enter the modules, you shall follow the instructions below:

***ABCD – Administration*** – http://demo.abcd-community.org/

_Rights: System Administrator, Database administrator, Database Operators, Loan administrator_
```text
User: abcd
Password: adm

```

*Rights: Database administrator, Database Operators*

```text
User: abcd
Password: dboper

```

***ABCD – OPAC (Public Interface)*** – https://demo.abcd-community.org/opac/

*For more examples, please refer to the [Documentation*](https://abcd-devcom.github.io/)

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make create value and are greatly appreciated.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/ABCD`)
3. Change or create a file (`git add [files changed]` or `git add .` for all files)
4. Commit your Changes (`git commit -m 'Add some ABCD Feature'`)
5. Push to the Branch (`git push -u origin master`)
6. Open a Pull Request

* to push to branch: `git push -u origin [name-of-branch]`
* to pull from master to local copy: `git pull origin master`
* to change from master to branch: `git checkout master/branch`

## License

ABCD is an application released to the public according to the terms of the [LGPLv3](https://www.gnu.org/licenses/lgpl-3.0.en.html) license, taking into consideration the disclaimers to protect the community and participating institutions from any liability regarding the access, development, distribution, use, merchantability and marketing related to the software.

ABCD reuses several other libraries and modules. These dependencies retain their original licenses.

For those interested in more information about the licensing, check http://www.opensource.org/licenses/alphabetical.
For a comparison between software licenses, check http://en.wikipedia.org/wiki/Comparison_of_free_software_licences.

## Contact

E-mail: [contact@abcd-community.org](mailto=contact@abcd-community.org)

Project Link: [https://github.com/ABCD-DEVCOM/ABCD/](https://www.google.com/search?q=https://github.com/ABCD-DEVCOM/ABCD/)

Website: [https://abcd-community.org/](https://abcd-community.org/)
