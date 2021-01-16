import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { FormGroup, FormControl, FormBuilder } from '@angular/forms';
import { ApprenantUserService } from '../../../../../service/apprenantUserService/apprenant-user.service';

@Component({
  selector: 'app-formulaire-put-apprenant',
  templateUrl: './formulaire-put-apprenant.component.html',
  styleUrls: ['./formulaire-put-apprenant.component.css']
})
export class FormulairePutApprenantComponent implements OnInit {

  apprenant = {};
  snapshot: RouterStateSnapshot;
  url;
  id;


  putApprenantForm: FormGroup;
  prenomFormControl = new FormControl();
  nomFormControl = new FormControl();
  emailFormControl = new FormControl();
  adresseFormControl = new FormControl();
  value;
  
  btnText = 'Ajouter';

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private apprenantUserService: ApprenantUserService
  ) { }

  ngOnInit(): void {
    this.apprenantUserService.getById(this.getIdOnUrl()).subscribe(
      (data : any) => {
        this.apprenant = data,
        console.log(data)
      }
    );
    this.putApprenantForm = this.formBuilder.group({
      prenom: this.prenomFormControl,
      nom: this.nomFormControl,
      email: this.emailFormControl,
      adresse: this.adresseFormControl
    });
  }

  getIdOnUrl() {
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    this.id = this.url.split('/');
    return this.id[4];
  }

  reloadComponentWithAlert() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/liste/apprenants']);
    alert('Données mofifier avec success');
  }

  onClickBtnValider() {
    if(this.prenomFormControl.value==null){
      this.prenomFormControl.setValue(this.apprenant['prenom']);
    }
    if(this.nomFormControl.value==null){
      this.nomFormControl.setValue(this.apprenant['nom']);
    }
    if(this.emailFormControl.value==null){
      this.emailFormControl.setValue(this.apprenant['email']);
    }
    if(this.adresseFormControl.value==null){
      this.adresseFormControl.setValue(this.apprenant['adresse']);
    }

    this.putApprenantForm = this.formBuilder.group({
      prenom: this.prenomFormControl,
      nom: this.nomFormControl,
      email: this.emailFormControl,
      adresse: this.adresseFormControl
    });

    if(this.putApprenantForm.value){
      return this.apprenantUserService.putApprenant(this.getIdOnUrl(),this.putApprenantForm.value).subscribe(
        (res: any) => {
          this.reloadComponentWithAlert()
        }
      );
    }
  }

}
