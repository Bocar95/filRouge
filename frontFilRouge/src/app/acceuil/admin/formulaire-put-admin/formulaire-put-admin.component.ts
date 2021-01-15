import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { FormControl, FormGroup, FormBuilder } from '@angular/forms';
import { AdminUserService } from 'src/app/service/adminUserService/admin-user.service';

@Component({
  selector: 'app-formulaire-put-admin',
  templateUrl: './formulaire-put-admin.component.html',
  styleUrls: ['./formulaire-put-admin.component.css']
})
export class FormulairePutAdminComponent implements OnInit {

  admin = {};
  snapshot: RouterStateSnapshot;
  url;
  id;


  putUserForm: FormGroup;
  prenomFormControl = new FormControl();
  nomFormControl = new FormControl();
  emailFormControl = new FormControl();
  adresseFormControl = new FormControl();
  value;
  
  btnText = 'Ajouter';

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private adminUserService: AdminUserService
  ) { }

  ngOnInit(): void {
    this.adminUserService.getById(this.getIdOnUrl()).subscribe(
      (data : any) => {
        this.admin = data,
        console.log(data)
      }
    );
    this.putUserForm = this.formBuilder.group({
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
    this.router.navigate(['/acceuil/liste/admins']);
    alert('Données mofifier avec success');
  }

  onClickBtnValider() {
    if(this.prenomFormControl.value==null){
      this.prenomFormControl.setValue(this.admin['prenom']);
    }
    if(this.nomFormControl.value==null){
      this.nomFormControl.setValue(this.admin['nom']);
    }
    if(this.emailFormControl.value==null){
      this.emailFormControl.setValue(this.admin['email']);
    }
    if(this.adresseFormControl.value==null){
      this.adresseFormControl.setValue(this.admin['adresse']);
    }

    this.putUserForm = this.formBuilder.group({
      prenom: this.prenomFormControl,
      nom: this.nomFormControl,
      email: this.emailFormControl,
      adresse: this.adresseFormControl
    });

    if(this.putUserForm.value){
      return this.adminUserService.putAdmin(this.getIdOnUrl(),this.putUserForm.value).subscribe(
        (res: any) => {
          this.reloadComponentWithAlert()
        }
      );
    }
  }

}
