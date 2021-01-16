import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { Router } from '@angular/router';
import { CmUserService } from 'src/app/service/cmUserService/cm-user.service';

@Component({
  selector: 'app-formulaire-add-cm',
  templateUrl: './formulaire-add-cm.component.html',
  styleUrls: ['./formulaire-add-cm.component.css']
})
export class FormulaireAddCmComponent implements OnInit {

  addingCm: FormGroup;
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
    private cmUserService: CmUserService
  ) { }

  ngOnInit(): void {
    this.addingCm = this.formBuilder.group({
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
    this.router.navigate(['/acceuil/ajouter/cm']);
    alert("Ajouter avec success");
  }

  onClickBtnAdd() {
    if(this.addingCm.value){
      return this.cmUserService.addCm(this.addingCm.value).subscribe(
        (res: any) => {
          console.log(res)
        }
        ),this.reloadComponent();
    }
  }

}
