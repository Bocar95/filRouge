import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { ConfirmationService } from 'primeng/api';
import { ApprenantUserService } from '../../../../service/apprenantUserService/apprenant-user.service';

@Component({
  selector: 'app-list-apprenant',
  templateUrl: './list-apprenant.component.html',
  styleUrls: ['./list-apprenant.component.css']
})
export class ListApprenantComponent implements OnInit {

  apprenants= [];
  btnAjouter = "Ajouter";
  btnNewApprenant = "Nouveau Apprenant";
  btnModifier = "Modifier";
  btnSupprimer = "Supprimer";
  snapshot: RouterStateSnapshot;
  id = [];
  url: string;
  first = 0;
  rows = 5;
  clonedProducts: { } = {};

  constructor(
    private apprenantUserService: ApprenantUserService,
    private router: Router,
    private confirmationService: ConfirmationService
  ) { }

  ngOnInit(): void {
    this.apprenantUserService.getApprenants().subscribe(
      (data : any) => {
        this.apprenants= data;
        console.log(data)
      }
    )
  }

  getIdOnUrl() {
    this.snapshot = this.router.routerState.snapshot;
    var url: string;
    url = this.snapshot['url'];
    this.id = url.split('/');
    return this.id[4];
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/liste/apprenants']);
  }

  confirmModalNo() {
    return this.reloadComponent();
  }

  currentRoute() {
    var split;
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    split = this.url.split('/');
    if(split[5] == `modifier`) {
      return true;
    }
    return false;
  }
  onRowEditInit(apprenant) {
    this.clonedProducts[apprenant.id] = {...apprenant};
  }

  onRowEditSave(apprenant, id) {
    console.log(apprenant);
    return this.apprenantUserService.putApprenant(id, apprenant).subscribe(
      (res: any) => { 
        console.log(res)
      }
    );
  }

  onRowEditCancel(apprenant, index: number) {
    this.apprenants[index] = this.clonedProducts[apprenant.id];
    delete this.clonedProducts[apprenant.id];
  }

  confirm(event: Event) {
    this.confirmationService.confirm({
        target: event.target,
        message: 'Êtes-vous sure de vouloir supprimer cet Apprenant?',
        icon: 'pi pi-exclamation-triangle',
        accept: () => {
          var toDelete: number;
          toDelete = this.getIdOnUrl();
          console.log(toDelete);
          //var toRemove = this.profils.slice().pop();
          return this.apprenantUserService.deleteApprenant(toDelete).subscribe(
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

}
