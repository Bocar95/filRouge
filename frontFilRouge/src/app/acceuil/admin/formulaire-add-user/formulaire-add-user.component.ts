import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { Router } from '@angular/router';
import { AdminUserService } from 'src/app/service/adminUserService/admin-user.service';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-formulaire-add-user',
  templateUrl: './formulaire-add-user.component.html',
  styleUrls: ['./formulaire-add-user.component.css']
})
export class FormulaireAddUserComponent implements OnInit {

  addingUser: FormGroup;
  prenomFormControl = new FormControl('', [Validators.required]);
  nomFormControl = new FormControl('', [Validators.required]);
  emailFormControl = new FormControl('', [Validators.required, Validators.email]);
  passwordFormControl = new FormControl('', [Validators.required]);
  adresseFormControl = new FormControl('', [Validators.required]);
  telephoneFormControl = new FormControl('', [Validators.required]);
  btnText = 'Ajouter';

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private adminUserService: AdminUserService
  ) { }

  ngOnInit(): void {
    this.addingUser = this.formBuilder.group({
      prenom: this.prenomFormControl,
      nom: this.nomFormControl,
      email: this.emailFormControl,
      password: this.passwordFormControl,
      adresse: this.adresseFormControl,
      telephone: this.telephoneFormControl
    });
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/ajouter/admin']);
    alert("Ajouter avec success");
  }

  onClickBtnAdd() {
    if(this.addingUser.value){
      return this.adminUserService.addAdmin(this.addingUser.value).subscribe(
        (res: any) => {
          console.log(res),
          this.reloadComponent()
        }
      )
    }
  }

}
