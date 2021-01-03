import { Component, OnInit } from '@angular/core';
import { ProfilService } from 'src/app/service/profil.service';
import { Router, RouterStateSnapshot } from '@angular/router';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';

@Component({
  selector: 'app-list-profils',
  templateUrl: './list-profils.component.html',
  styleUrls: ['./list-profils.component.css']
})

export class ListProfilsComponent implements OnInit {

  profils = [];
  btnDetail = "Detail";
  btnModifier = "Modifier";
  btnSupprimer = "Supprimer";
  snapshot: RouterStateSnapshot;
  url: string;
  id = [];
  toDelete: number;
  toUpdate: number;
  i = 0;
  j = 0;
  updatingProfil: FormGroup;
  libelleFormControl = new FormControl('', [Validators.required]);
  public page= 1;
  public pageSize= 5;

  constructor(private profilService: ProfilService,
              private router: Router,
              private formBuilder: FormBuilder){  }

  ngOnInit(): void {
    this.profilService.getProfil().subscribe(
      (data: any) => {
        this.profils = data;
        console.log(data)
      }
    );
    this.updatingProfil = this.formBuilder.group({
      libelle : this.libelleFormControl 
    });
  }

  getIdOnUrl() {
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    this.id = this.url.split('/');
    return this.id[2];
  }

  reloadCurrentRoute() {
    let currentUrl = this.router.url;
    return this.router.navigateByUrl('/', {skipLocationChange: true}).then(() => {
        this.router.navigate([currentUrl]);
    });
  }

  reloadComponent() {
    let currentUrl = this.router.url;
        this.router.routeReuseStrategy.shouldReuseRoute = () => false;
        this.router.onSameUrlNavigation = 'reload';
        this.router.navigate(['/acceuil']);
  }

  onClickBtnPut() {
    this.toUpdate= this.getIdOnUrl();
    return this.profilService.putProfil(this.toUpdate, this.updatingProfil.value).subscribe(
      (res: any) => { 
        this.reloadComponent();
        console.log(res)
      }
    );
  }

  onClickBtnDelete() {
    this.toDelete = this.getIdOnUrl();
    //var toRemove = this.profils.slice().pop();
     return this.profilService.deleteProfil(this.toDelete).subscribe(
      (res: any) => { 
        this.reloadComponent();
        console.log(res)
      }
    );
  }

  confirmModalNo() {
    return this.reloadComponent();
  }

  totalElement() {
    while(this.profils[this.i]) {
      this.j = this.j+1;
      this.i++;
    }
    return this.j;
  }

}
