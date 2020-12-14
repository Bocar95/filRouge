import { Component, OnInit } from '@angular/core';
import { Router } from  '@angular/router';

@Component({
  selector: 'app-acceuil',
  templateUrl: './acceuil.component.html',
  styleUrls: ['./acceuil.component.css']
})
export class AcceuilComponent implements OnInit {

  constructor(private router: Router) { }

  ngOnInit(): void {
  }

  urlAdmin() {
    if (this.router.url == "/acceuil/admin") {
      return true;
    } 
  }

  urlFormateur() {
    if (this.router.url == "/acceuil/formateur") {
      return true;
    } 
  }

  urlCm() {
    if (this.router.url == "/acceuil/cm") {
      return true;
    } 
  }

  urlApprenant() {
    if (this.router.url == "/acceuil/apprenant") {
      return true;
    } 
  }

}
