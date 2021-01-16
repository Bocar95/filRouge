import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, FormBuilder } from '@angular/forms';
import { Router, RouterStateSnapshot } from '@angular/router';
import { FormateurUserService } from '../../../../../service/formateurUserService/formateur-user.service';

@Component({
  selector: 'app-formulaire-put-formateur',
  templateUrl: './formulaire-put-formateur.component.html',
  styleUrls: ['./formulaire-put-formateur.component.css']
})
export class FormulairePutFormateurComponent implements OnInit {

  formateur = {};
  snapshot: RouterStateSnapshot;
  url;
  id;


  putFormateurForm: FormGroup;
  prenomFormControl = new FormControl();
  nomFormControl = new FormControl();
  emailFormControl = new FormControl();
  adresseFormControl = new FormControl();
  value;
  
  btnText = 'Ajouter';

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private formateurUserService: FormateurUserService
  ) { }

  ngOnInit(): void {
    this.formateurUserService.getById(this.getIdOnUrl()).subscribe(
      (data : any) => {
        this.formateur = data,
        console.log(data)
      }
    );
    this.putFormateurForm = this.formBuilder.group({
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
    this.router.navigate(['/acceuil/liste/formateurs']);
    alert('Données mofifier avec success');
  }

  onClickBtnValider() {
    if(this.prenomFormControl.value==null){
      this.prenomFormControl.setValue(this.formateur['prenom']);
    }
    if(this.nomFormControl.value==null){
      this.nomFormControl.setValue(this.formateur['nom']);
    }
    if(this.emailFormControl.value==null){
      this.emailFormControl.setValue(this.formateur['email']);
    }
    if(this.adresseFormControl.value==null){
      this.adresseFormControl.setValue(this.formateur['adresse']);
    }

    this.putFormateurForm = this.formBuilder.group({
      prenom: this.prenomFormControl,
      nom: this.nomFormControl,
      email: this.emailFormControl,
      adresse: this.adresseFormControl
    });

    if(this.putFormateurForm.value){
      return this.formateurUserService.putFormateur(this.getIdOnUrl(),this.putFormateurForm.value).subscribe(
        (res: any) => {
          this.reloadComponentWithAlert()
        }
      );
    }
  }

}
