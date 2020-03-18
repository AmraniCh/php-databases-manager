# Databases Manager API

<h3>Description</h3>
<p>This project is a simulation of PHPMyAdmin, it allows you to control all of your data (excluding data definition mechanisms)</p>

![](https://i.imgur.com/QDV1Kzq.png)

<h5>Database Schema Visualization</h5>

![](https://i.imgur.com/8hfwPXP.png)
![](https://i.imgur.com/wR6mgGq.png)

<h3>Functionalities</h3>

<ul>
  <li>The application depends on user's authentication.</li>
  <li>It provides the user the ability to navigate all databases -as well as their tables- whom he is allowed to see.</li>
  <li>Not to mention, it also serves the possibility of editing, inserting and deleting records.</li>
  <li>Showing current user permissions concerning the database selected.</li>
  <li><b>[New] </b>The possibility of visualizing a database schema.</li>
</ul>

## Usage

Download from github, clone the repo :

```console
  git clone https://github.com/ELAMRANI744/Databases-Manager-api
```

Then run application in localhost :

```
  localhost[:port]/Databases-Manager-api
```

## What's included

```
Databases Manager API
├── css
|  ├── animation.css
|  ├── app.css
|  ├── bootstrap.min.css
|  ├── datatables.css
|  ├── jquery.dataTables.css
|  ├── loaders.css
|  ├── normalize.css
|  |  ├── CHANGELOG.md
|  |  ├── LICENSE.md
|  |  ├── normalize.css
|  |  ├── package.json
|  |  └── README.md
|  ├── standard.css
|  ├── vendor.bundle.addons.css
|  └── vendor.bundle.base.css
├── fonts
|  └── mdi
|     ├── bower.json
|     ├── css
|     ├── fonts
|     ├── license.md
|     ├── package.json
|     ├── preview.html
|     ├── README.md
|     └── scss
├── index.php
├── js
|  ├── componenets.js
|  ├── jquery.dataTables.min.js
|  ├── jquery.min.js
|  ├── loaders.js
|  ├── main.js
|  └── utilities.js
├── logs
|  └── logs.txt
├── modules
|  ├── handler.php
|  ├── loader.php
|  ├── models
|  |  ├── column.php
|  |  ├── container.php
|  |  ├── database.php
|  |  ├── manager.php
|  |  └── table.php
|  └── utilities
|     ├── logsManager.php
|     ├── queryHelper.php
|     └── userManager.php
├── package-lock.json
├── package.json
├── README.md
├── test_units
|  ├── controlledData.html
|  ├── createUser.php
|  ├── encryption.php
|  ├── permission
|  |  ├── grant.php
|  |  ├── kick.php
|  |  └── register.php
|  ├── tablesJsonData.php
|  ├── test.php
|  └── updating.php
└── views
   ├── componenets
   |  ├── datatables
   |  ├── header.php
   |  ├── logsPanel.html
   |  ├── modals
   |  ├── sectionHeader.html
   |  └── sectionHeader_permissions.html
   ├── home.php
   ├── login.html
   ├── permissions.php
   ├── permissionsSectionContent.php
   ├── tableDataTabsView.php
   └── tableDataVerticalView.php
```

## License

Copyright 2020 To (<b>EL AMRANI CHAKIR, IBRAHIM AREDA</b>) Team Licensed under MIT (https://github.com/ELAMRANI744/Databases-Manager-api/blob/master/LICENSE).

## Wireframing & Mockup

See in **[Behance](https://www.behance.net/gallery/90446911/Databases-Manager-API)**.


