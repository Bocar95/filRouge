import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { Router } from '@angular/router';
import { FormateurUserService } from '../../../../../service/formateurUserService/formateur-user.service';

@Component({
  selector: 'app-formulaire-add-formateur',
  templateUrl: './formulaire-add-formateur.component.html',
  styleUrls: ['./formulaire-add-formateur.component.css']
})
export class FormulaireAddFormateurComponent implements OnInit {

  addingFormateur: FormGroup;
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
    private formateurUserService: FormateurUserService
  ) { }

  ngOnInit(): void {
    this.addingFormateur = this.formBuilder.group({
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
    this.router.navigate(['/acceuil/ajouter/formateur']);
    alert("Ajouter avec success");
  }

  onClickBtnAdd() {
    if(this.addingFormateur.value){
      return this.formateurUserService.addFormateur(this.addingFormateur.value).subscribe(
        (res: any) => {
          console.log(res)
        }
        ),this.reloadComponent();
    }
  }

}
