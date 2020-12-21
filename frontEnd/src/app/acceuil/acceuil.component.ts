import { Component, OnInit } from '@angular/core';
import { Router } from  '@angular/router';
import { VerifyTokenService } from '../service/verify-token.service';

@Component({
  selector: 'app-acceuil',
  templateUrl: './acceuil.component.html',
  styleUrls: ['./acceuil.component.css']
})
export class AcceuilComponent implements OnInit {

  constructor(private router: Router, private verifyToken: VerifyTokenService) { }

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

  urlAdmin() {
    if (this.userRole() == "ROLE_ADMIN") {
      return true;
    } 
  }

  urlFormateur() {
    if (this.userRole() == "ROLE_FORMATEUR") {
      return true;
    } 
  }

  urlCm() {
    if (this.userRole() == "ROLE_CM") {
      return true;
    } 
  }

  urlApprenant() {
    if (this.userRole() == "ROLE_APPRENANT") {
      return true;
    } 
  }

}
