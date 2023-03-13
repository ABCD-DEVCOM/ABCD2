<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://abcd-community.org/" target="_blank">
    <img src="https://abcd-community.org/wp-content/uploads/2021/06/ABCD_logo_rasterizado-02.png" alt="Logo" width="400" >
  </a>

  <h3 align="center">ABCD v2.x based on CISIS</h3>

  <p align="center">
    Welcome to the development of the ABCD!
    <br />
    <a href="https://github.com/ABCD-DEVCOM/ABCD2/blob/master/ABCofABCD_2.0f.pdf" target="_blank"><strong>Explore the ABC of ABCD »</strong></a>
    <br />
    <br />
    <a href="https://demo.abcd-community.org/" target="_blank">View Demo</a>
    ·
    <a href="https://github.com/ABCD-DEVCOM/ABCD2/issues">Report Bug</a>
    ·
    <a href="https://github.com/ABCD-DEVCOM/ABCD2/issues">Request Feature</a>
  </p>
</p>



<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
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
![module_cataloging](https://user-images.githubusercontent.com/64411779/221262002-5b36053b-8294-4a67-aa63-804acb6e5e63.png)



Acronym **ABCD** stands for:

> **A**utomatización de **B**ibliotecas y **C**entros de **D**ocumentación<br>
> **A**utomation des **B**ibliothèques et **C**entres de **D**ocumentacion<br>
> **A**utomatização das **B**ibliotecas e dos **C**entros de **D**ocumentação<br>
> **A**utomatisering van **B**ibliotheken en **C**entra voor **D**ocumentatie

ABCD was initially developed by [Bireme](http://regional.bvsalud.org/local/Site/bireme/I/homepage.htm) with the support of [VLIR/UOS](https://www.vliruos.be/en/home/1) and based on [UNESCO-supported ISIS-technology](http://www.unesco.org/isis). Currently the development is solely done by volunteers in several countries but not enough thanks can be given to G. Ascencio and E. Spinak.

---

The name itself already expresses the ambition of the software suite : not only providing automation functions for
the 'classic' libraries but also other information providers such as documentation centres. Flexibility and versatility
are at the forefront of the criteria on which the software is developed. This flexibility e.g. is illustrated by the
fact that in principle, but also practically, any bibliographic structure can be managed by the software, or even
created by itself. Even non-bibliographic structures can be created, as long as the information is mainly 'textual'
information, as this is the limitation put by the underlying database technology, which is the (CDS/)ISIS textual
database. Good understanding of some basic ISIS-related concepts and techniques, e.g. the Formatting Language,
is crucial for full mastering of the ABCD-software. For this reason some sections of this Manual will also deal
with the underlying ISIS-technology.

ABCD is called a 'suite' of softwares for library and documentation centres automation because it exists of some
relatively independent modules, which can fully co-operate but also can exist without each other. In fact some
existing advanced softwares, mostly having already shown their potential in demanding environments in BIREME-
applications (within the Virtual Health Library context), were adopted and adapted into ABCD - that is why the
original names such as iAH, SeCS (both developed by BIREME) and EmpWeb (Empréstimos en Web) developed
originally by KALIO ltda. of Uruguay and amply tested in Valparaiso at the University) are maintained. These main
parts are shown, with their hierarchical relationships, at the second level in the following picture:

![estructure_ABCD-1024x576](https://user-images.githubusercontent.com/20482054/124363175-28618800-dc10-11eb-85c9-b2630cfaaad3.jpg)



### Built With

ABCD is being written using the languages.
* [PHP](https://www.php.net/)
* [CISIS](https://wiki.bireme.org/pt/index.php/CISIS)
* [HTML](https://en.wikipedia.org/wiki/HTML)
* [JavaScript](https://en.wikipedia.org/wiki/JavaScript)


<!-- DOWNLOAD and Install -->
## Installation
ABCD is supported on **Windows** and **Linux**  
[Download the latest ABCD release](https://abcd-community.org/dowloads/)  
[Download all code from GitHub ABCD-DEVCOM / ABCD2](https://github.com/ABCD-DEVCOM/ABCD2)  
 

Installation prerequisites and installation procedure vary by version and by installed components.
See [Installation folder](https://github.com/ABCD-DEVCOM/ABCD2/tree/master/zz_installation) for detailed instructions and material.
Note that the ABCD downloads do not include software prerequisites

[Download EmpWeb](https://github.com/ABCD-Community/EmpWeb)

`EmpWeb` has additional prerequisites (SQL,Java). Details in the repository.



<!-- USAGE EXAMPLES -->
## Usage

You can try the ABCD software on an online installation of the ABCD. All features that you can access come with the default installation package of ABCD.

Our demo version is synchronized with the development in the Github repository, so there may be some bugs.

We will soon make a more stable demo version available in parallel with development for comparison

Instructions
To enter the modules, you shall follow the instructions below:


***ABCD – Administration*** – http://demo.abcd-community.org/

_Rights: System Administrator, Database administrator, Database Operators, Loan administrator_
 ```
 User: abcd
 Password: adm
  ```  
  
_Rights: Database administrator, Database Operators_
```
User: abcd
Password: dboper
```  

 
***ABCD – Public site*** – https://demo.abcd-community.org/site/

***ABCD – Public site administrator*** – https://demo.abcd-community.org/site/admin

_Rights: Administrator_
```
User: adm
Password: x
 ```  

_For more examples, please refer to the [Documentation](https://github.com/ABCD-DEVCOM/ABCD2/blob/master/ABCofABCD_2.0f.pdf)_


<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/ABCD2`)
3. Change or create a file (`git add [files changed]  or : git add . `(for all files))
4. Commit your Changes (`git commit -m 'Add some ABCD2Feature'`)
5. Push to the Branch (`git push -u origin master`)
6. Open a Pull Request

* to push to branch : git push -u origin [name-of-branch]
* to pull from master to local copy : git pull origin master
* to change from master to branch : git checkout master/branch


<!-- LICENSE -->
## License

ABCD is an application of software released to the public according to the terms of the [LGPLv3](https://www.gnu.org/licenses/lgpl-3.0.en.html) license, taking into consideration the disclaimers to protect BIREME and other institutions participants on any liability regarding the access, development, distribution, use, merchantability and marketing related to the software;

ABCD reuses several other libraries and modules. These dependencies retain their original licenses.

For those interested in more information about the licensing, check http://www.opensource.org/licenses/alphabetical.

For a comparisom between software licenses, check http://en.wikipedia.org/wiki/Comparison_of_free_software_licences.



<!-- CONTACT -->
## Contact

E-mail - [contact@abcd-community.org](contact@abcd-community.org)

Project Link: [https://github.com/ABCD-DEVCOM/ABCD2/](https://github.com/ABCD-DEVCOM/ABCD2/)

Website: https://abcd-community.org/


