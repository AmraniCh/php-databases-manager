"use strict"

$(document).ready(function(){

  // TABLE ACTIONS BTNS
  $(document).on("click", ".table-actions button", function(){
    const $this = $(this);
    $(".table-actions button").each(function(){ $(this).removeClass("active") })
    $this.toggleClass("active")
    if($this.data("type") == "data"){
      $("#table-structure_wrapper").hide(0)
      $("#table-data_wrapper").show(0)
    }
    if($this.data("type") == "structure"){
      $("#table-data_wrapper").hide(0)
      $("#table-structure_wrapper").show(0)
    }
  })

  // SETTING BTN CLICK
  $(document).on("click", "#settings-btn", function(){
    $(".settings-menu").toggle()
  })

  // FILTER BUTTON
  $(document).on("click", "#filter-button", function(e){
    e.stopPropagation()
  })

  // SIDEBAR PANEL DATABASE ITEM TOGGLE TABLES
  $(document).on("click", ".database-item", function(){
    const $this = $(this);
    if( $this.closest(".database-item").attr("data-toggle") == "open" ){
      $this.closest(".database-item").attr("data-toggle", "close")
      $this.closest(".database-item").css("border-bottom", "3px solid var(--black)")
      $this.closest(".database-toggle").find(".database-table-items").slideToggle(200)
    } else{
      $this.closest(".database-item").attr("data-toggle", "open")
      $this.closest(".database-item").css("border-bottom", "none")
      $this.closest(".database-toggle").find(".database-table-items").slideToggle(300)
    }
  });

  // SIDEBAR PANEL USER ITEM TOGGLE TABLES
  $(document).on("click", ".user-item", function(){
    $.each($(".user-item"), function(){
      $(this).removeClass("selected")
    })
    $this.closest(".user-item").addClass("selected")
  });

  // SIDEBAR PANEL FILTER PANEL TOGGLE DATABASES
  $(document).on("click", ".filter-panel", function(){
    const $this = $(this);
    if( $this.closest(".filter-panel").attr("data-toggle") == "open" ){
      $this.closest(".filter-panel").attr("data-toggle", "close")
      $this.closest(".sidebar").find(".sidebar-databases-items").slideToggle(300)
    }else{
      $this.closest(".filter-panel").attr("data-toggle", "open")
      $this.closest(".sidebar").find(".sidebar-databases-items").slideToggle(300)
    }
  })

  // TOGGLE DATATABLE BTNS
  $(document).on("click", ".toggle-table-btn", function(){
    const $this = $(this)
    const dataType = $this.data("type")
    const toggle = $this.attr("data-toggle")
    if( toggle == "open" ){
      ( dataType == "data" ) ? $("#table-data_wrapper").hide(0) : $("#table-structure_wrapper").hide(0)
      $this.attr("data-toggle", "close")
    }
    else{
      ( dataType == "data" ) ? $("#table-data_wrapper").show(0) : $("#table-structure_wrapper").show(0)
      $this.attr("data-toggle", "open")
    }

  })

})
