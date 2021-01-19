import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { Router } from '@angular/router';
import { ApprenantUserService } from '../../../../../service/apprenantUserService/apprenant-user.service';

@Component({
  selector: 'app-formulaire-add-apprenant',
  templateUrl: './formulaire-add-apprenant.component.html',
  styleUrls: ['./formulaire-add-apprenant.component.css']
})
export class FormulaireAddApprenantComponent implements OnInit {

  addingApprenant: FormGroup;
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
    private apprenantUserService: ApprenantUserService
  ) { }

  ngOnInit(): void {
    this.addingApprenant = this.formBuilder.group({
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
    this.router.navigate(['/acceuil/ajouter/apprenant']);
    alert("Ajouter avec success");
  }

  onClickBtnAdd() {
    if(this.addingApprenant.value){
      return this.apprenantUserService.addApprenant(this.addingApprenant.value).subscribe(
        (res: any) => {
          console.log(res)
        }
      ),this.reloadComponent();
    }
  }

}
