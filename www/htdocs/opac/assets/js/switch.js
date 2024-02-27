/**
 *  Light Switch @version v0.1.4
 */

(function () {
  let lightSwitch = document.getElementById('lightSwitch');
  if (!lightSwitch) {
    return;
  }

  /**
   * @function darkmode
   * @summary: changes the theme to 'dark mode' and save settings to local stroage.
   * Basically, replaces/toggles every CSS class that has '-white' class with '-dark'
   */
  function darkMode() {
    document.querySelectorAll('.bg-white').forEach((element) => {
      element.className = element.className.replace(/bg-white/g, 'bg-dark');
    });

    document.querySelectorAll('.bg-light').forEach((element) => {
      element.className = element.className.replace(/bg-light/g, 'bg-black');
    });

    document.querySelectorAll('.text-bg-light').forEach((element) => {
      element.className = element.className.replace(/text-bg-light/g, 'text-bg-dark');
    });


    document.querySelectorAll('.bg-light-subtle').forEach((element) => {
      element.className = element.className.replace(/-light-subtle/g, '-dark');
    });

    document.querySelectorAll('.btn-light').forEach((element) => {
      element.className = element.className.replace(/btn-light/g, 'btn-dark');
    });

    document.querySelectorAll('.btn-submit').forEach((element) => {
      element.className = element.className.replace(/btn-submit/g,  'original-btn-submit');
    });

    document.querySelectorAll('.custom-footer').forEach((element) => {
      element.className = element.className.replace(/custom-footer/g, 'original-custom-footer');
    });

    document.querySelectorAll('.custom-top-link').forEach((element) => {
      element.className = element.className.replace(/custom-top-link/g, 'original-top-link');
    });

    document.querySelectorAll('.custom-sidebar').forEach((element) => {
      element.className = element.className.replace(/custom-sidebar/g, 'original-sidebar');
    });
    
    document.querySelectorAll('.custom-searchbox').forEach((element) => {
      element.className = element.className.replace(/custom-searchbox/g, 'original-searchbox');
    });

    document.querySelectorAll('.link-dark').forEach((element) => {
      element.className = element.className.replace(/link-dark/, 'text-white');
    });

    document.querySelectorAll('.text-dark').forEach((element) => {
      element.className = element.className.replace(/text-dark/, 'text-white');
    });

    document.body.classList.add('bg-black');

    if (document.body.classList.contains('text-dark')) {
      document.body.classList.replace('text-dark', 'text-white');
    } else {
      document.body.classList.add('text-white');
    }


    // Tables
    var tables = document.querySelectorAll('table');
    for (var i = 0; i < tables.length; i++) {
      // add table-dark class to each table
      tables[i].classList.add('table-dark');
    }

    // set light switch input to true
    if (!lightSwitch.checked) {
      lightSwitch.checked = true;
    }
    localStorage.setItem('lightSwitch', 'dark');
  }

  /**
   * @function lightmode
   * @summary: changes the theme to 'light mode' and save settings to local stroage.
   */
  function lightMode() {
    document.querySelectorAll('.bg-dark').forEach((element) => {
      element.className = element.className.replace(/bg-dark/g, 'bg-white');
    });

    document.querySelectorAll('.bg-dark').forEach((element) => {
      element.className = element.className.replace(/bg-dark/g, 'bg-light');
    });
    document.querySelectorAll('.original-btn-submit').forEach((element) => {
      element.className = element.className.replace(/original-btn-submit/g, 'btn-submit');
    });

    document.querySelectorAll('.original-custom-footer').forEach((element) => {
      element.className = element.className.replace(/original-custom-footer/g, 'custom-footer');
    });

    document.querySelectorAll('.original-top-link').forEach((element) => {
      element.className = element.className.replace(/original-top-link/g, 'custom-top-link');
    });

    document.querySelectorAll('.original-sidebar').forEach((element) => {
      element.className = element.className.replace(/original-sidebar/g, 'custom-sidebar');
    });

    document.querySelectorAll('.original-searchbox').forEach((element) => {
      element.className = element.className.replace(/original-searchbox/g, 'custom-searchbox');
    });

    document.querySelectorAll('.text-bg-dark').forEach((element) => {
      element.className = element.className.replace(/text-bg-dark/g, 'text-bg-light');
    });

    document.querySelectorAll('.bg-dark').forEach((element) => {
      element.className = element.className.replace(/-light-subtle/g, '-light-subtle');
    });

    document.querySelectorAll('.btn-dark').forEach((element) => {
      element.className = element.className.replace(/btn-dark/g, 'btn-light');
    });



    document.body.classList.add('bg-light-subtle');

    if (document.body.classList.contains('text-white')) {
      document.body.classList.replace('text-white', 'text-dark');
    } else {
      document.body.classList.add('text-dark');
    }

    // Tables
    var tables = document.querySelectorAll('table');
    for (var i = 0; i < tables.length; i++) {
      if (tables[i].classList.contains('table-dark')) {
        tables[i].classList.remove('table-dark');
      }
    }

    if (lightSwitch.checked) {
      lightSwitch.checked = false;
    }
    localStorage.setItem('lightSwitch', 'light');
  }

  /**
   * @function onToggleMode
   * @summary: the event handler attached to the switch. calling @darkMode or @lightMode depending on the checked state.
   */
  function onToggleMode() {
    if (lightSwitch.checked) {
      darkMode();
    } else {
      lightMode();
    }
  }

  /**
   * @function getSystemDefaultTheme
   * @summary: get system default theme by media query
   */
  function getSystemDefaultTheme() {
    const darkThemeMq = window.matchMedia('(prefers-color-scheme: dark)');
    if (darkThemeMq.matches) {
      return 'dark';
    }
    return 'light';
  }

  function setup() {
    var settings = localStorage.getItem('lightSwitch');
    if (settings == null) {
      settings = getSystemDefaultTheme();
    }

    if (settings == 'dark') {
      lightSwitch.checked = true;
    }

    lightSwitch.addEventListener('change', onToggleMode);
    onToggleMode();
  }

  setup();
})();



// Acessibility

function fonte(e) {
  let elemento = $("body");
  let fonte = elemento.css('font-size');

  if (e == 'a') {
    elemento.css("fontSize", parseInt(fonte) + 1);
  } else if ('d') {
    elemento.css("fontSize", parseInt(fonte) - 1);
  }
}