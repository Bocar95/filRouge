import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-acceuil-header',
  templateUrl: './acceuil-header.component.html',
  styleUrls: ['./acceuil-header.component.css']
})
export class AcceuilHeaderComponent implements OnInit {

  constructor() { }

  ngOnInit(): void {
  }


  userRole () {
    let token = localStorage.getItem('token');
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    var test = JSON.parse(jsonPayload);
  
    return test["roles"];
  }

  Admin() {
    if (this.userRole() == "ROLE_ADMIN") {
      return true;
    } 
  }

  Formateur() {
    if (this.userRole() == "ROLE_FORMATEUR") {
      return true;
    } 
  }

  Cm() {
    if (this.userRole() == "ROLE_CM") {
      return true;
    } 
  }

  Apprenant() {
    if (this.userRole() == "ROLE_APPRENANT") {
      return true;
    } 
  }

}
