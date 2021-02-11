import { Component, OnInit } from '@angular/core';
import { ProfilService } from 'src/app/service/profilService/profil.service';
import { Router, RouterStateSnapshot } from '@angular/router';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { ConfirmationService, MessageService, SelectItem } from 'primeng/api';

@Component({
  selector: 'app-list-profils',
  templateUrl: './list-profils.component.html',
  styleUrls: ['./list-profils.component.css'],
  styles: [`
      :host ::ng-deep .p-cell-editing {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
      }
  `]
})

export class ListProfilsComponent implements OnInit {

  elements1 = [];
  snapshot: RouterStateSnapshot;
  url: string;
  id = [];
  toDelete: number;
  toUpdate: number;
  toDetails: number;
  updatingProfil: FormGroup;
  libelleFormControl = new FormControl('', [Validators.required]);
  first = 0;
  rows = 4;

  clonedProducts: { } = {};

  constructor(
    private profilService: ProfilService,
    private router: Router,
    private formBuilder: FormBuilder,
    private confirmationService : ConfirmationService
  ){  }

  ngOnInit(): void {
    this.profilService.getProfil().subscribe(
      (data: any) => {
        this.elements1 = data;
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
    return this.id[4];
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
    this.router.navigate(['/acceuil/liste/profils']);
  }

  onClickBtnDetails(toLoad) {
    this.reloadComponent();
    return this.router.navigate([`/acceuil/liste/profils/${toLoad}/details`]);
  }

  onRowEditInit(profil) {
    this.clonedProducts[profil.id] = {...profil};
  }

  onRowEditSave(profil, id) {
    return this.profilService.putProfil(id, profil).subscribe(
      (res: any) => { 
        console.log(res)
      }
    );
  }

  onRowEditCancel(profil, index: number) {
    this.elements1[index] = this.clonedProducts[profil.id];
    delete this.clonedProducts[profil.id];
  }

  confirm(event: Event) {
    this.confirmationService.confirm({
        target: event.target,
        message: 'Êtes-vous sure de vouloir supprimer ce profil?',
        icon: 'pi pi-exclamation-triangle',
        accept: () => {
          this.toDelete = this.getIdOnUrl();
          //var toRemove = this.profils.slice().pop();
           return this.profilService.deleteProfil(this.toDelete).subscribe(
            (res: any) => { 
              this.reloadComponent();
              console.log(res)
            }
          );
        },
        reject: () => {
          // return this.reloadComponent();
        }
    });
  }

  currentRoute() {
    var split;
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    split = this.url.split('/');
    if(split[5] == `details`) {
      return true;
    }
    return false;
  }

}
