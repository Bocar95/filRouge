import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
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

  constructor(
    private ApprenantUserService: ApprenantUserService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.ApprenantUserService.getApprenants().subscribe(
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

  onClickBtnPut(id) {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    return this.router.navigate([`/acceuil/liste/apprenants/${id}/modifier`]);
  }

  onClickBtnDelete() {
    var toDelete: number;
    toDelete = this.getIdOnUrl();
    console.log(toDelete);
    //var toRemove = this.profils.slice().pop();
     return this.ApprenantUserService.deleteApprenant(toDelete).subscribe(
      (res: any) => { 
        this.reloadComponent();
        console.log(res)
      }
    );
  }

}
