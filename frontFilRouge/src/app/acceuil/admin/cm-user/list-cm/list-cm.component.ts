import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { CmUserService } from '../../../../service/cmUserService/cm-user.service';

@Component({
  selector: 'app-list-cm',
  templateUrl: './list-cm.component.html',
  styleUrls: ['./list-cm.component.css']
})
export class ListCmComponent implements OnInit {

  cms = [];
  btnAjouter = "Ajouter";
  btnNewCm = "Nouveau Admin";
  btnModifier = "Modifier";
  btnSupprimer = "Supprimer";
  snapshot: RouterStateSnapshot;
  id = [];
  url: string;

  constructor(
    private cmUserService: CmUserService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.cmUserService.getCms().subscribe(
      (data : any) => {
        this.cms = data;
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
    this.router.navigate(['/acceuil/liste/cms']);
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
    return this.router.navigate([`/acceuil/liste/cms/${id}/modifier`]);
  }

  onClickBtnDelete() {
    var toDelete: number;
    toDelete = this.getIdOnUrl();
    console.log(toDelete);
    //var toRemove = this.profils.slice().pop();
     return this.cmUserService.deleteCm(toDelete).subscribe(
      (res: any) => { 
        this.reloadComponent();
        console.log(res)
      }
    );
  }

}