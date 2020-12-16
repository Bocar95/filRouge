import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from  '@angular/forms';
import { Router } from  '@angular/router';
import { Utilisateur } from  '../utilisateur';
import { AuthService } from  '../auth.service';
import { ApiService } from '../api.service';
import {FormControl} from '@angular/forms';

@Component({
  selector: 'app-connexion',
  templateUrl: './connexion.component.html',
  styleUrls: ['./connexion.component.css']
})
export class ConnexionComponent implements OnInit {

  loginForm: FormGroup;
  hide = true;

  emailFormControl = new FormControl('', [Validators.required, Validators.email]);

  passwordFormControl = new FormControl('', [Validators.required]);

  constructor(private authService: AuthService, private router: Router, private apiService: ApiService, private formBuilder: FormBuilder ) { }
  
  ngOnInit() {
      this.loginForm  =  this.formBuilder.group({
          email: this.emailFormControl,
          password: this.passwordFormControl
      });
  }

  getErrorMessage() {
    if (this.emailFormControl.hasError('required')) {
      return 'Veuillez saisir votre email.';
    }else
    if (this.emailFormControl.hasError('email')) {
      return 'Veuillez saisir un email correct.';
    }
  }

  loginUser(){
    this.authService.loginUser(this.loginForm.value)
      .subscribe(
        res => console.log(res),
        err => console.log(err)
      )
  }

  // getformControls() { 
  //   return this.loginForm.controls; 
  // }
  
  // seConnecter(){
  //   console.log(this.loginForm.value);
  //   if(this.loginForm.invalid){
  //     return ('dioumgeuh');
  //   }
  //   this.authService.seConnecter(this.loginForm.value);
  //   this.router.navigateByUrl('/acceuil/admin');
  //   //this.apiService.readProfil();
  // }

}