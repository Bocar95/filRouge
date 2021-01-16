import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, FormBuilder } from '@angular/forms';
import { Router, RouterStateSnapshot } from '@angular/router';
import { CmUserService } from 'src/app/service/cmUserService/cm-user.service';

@Component({
  selector: 'app-formulaire-put-cm',
  templateUrl: './formulaire-put-cm.component.html',
  styleUrls: ['./formulaire-put-cm.component.css']
})
export class FormulairePutCmComponent implements OnInit {

  cm = {};
  snapshot: RouterStateSnapshot;
  url;
  id;


  putCmForm: FormGroup;
  prenomFormControl = new FormControl();
  nomFormControl = new FormControl();
  emailFormControl = new FormControl();
  adresseFormControl = new FormControl();
  value;
  
  btnText = 'Ajouter';

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private cmUserService: CmUserService
  ) { }

  ngOnInit(): void {
    this.cmUserService.getById(this.getIdOnUrl()).subscribe(
      (data : any) => {
        this.cm = data,
        console.log(data)
      }
    );
    this.putCmForm = this.formBuilder.group({
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
    this.router.navigate(['/acceuil/liste/cms']);
    alert('Données mofifier avec success');
  }

  onClickBtnValider() {
    if(this.prenomFormControl.value==null){
      this.prenomFormControl.setValue(this.cm['prenom']);
    }
    if(this.nomFormControl.value==null){
      this.nomFormControl.setValue(this.cm['nom']);
    }
    if(this.emailFormControl.value==null){
      this.emailFormControl.setValue(this.cm['email']);
    }
    if(this.adresseFormControl.value==null){
      this.adresseFormControl.setValue(this.cm['adresse']);
    }

    this.putCmForm = this.formBuilder.group({
      prenom: this.prenomFormControl,
      nom: this.nomFormControl,
      email: this.emailFormControl,
      adresse: this.adresseFormControl
    });

    if(this.putCmForm.value){
      return this.cmUserService.putCm(this.getIdOnUrl(),this.putCmForm.value).subscribe(
        (res: any) => {
          this.reloadComponentWithAlert()
        }
      );
    }
  }

}
