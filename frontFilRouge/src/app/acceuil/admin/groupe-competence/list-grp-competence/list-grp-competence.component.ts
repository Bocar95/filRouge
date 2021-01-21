import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { GroupeCompetenceService } from 'src/app/service/groupeCompetenceService/groupe-competence.service';

@Component({
  selector: 'app-list-grp-competence',
  templateUrl: './list-grp-competence.component.html',
  styleUrls: ['./list-grp-competence.component.css']
})
export class ListGrpCompetenceComponent implements OnInit {

  grpCompetences = [];
  btnAjouter = "Ajouter";
  btnNewGrpCompetence = "Nouveau";
  btnModifier = "Modifier";
  btnSupprimer = "Supprimer";
  snapshot: RouterStateSnapshot;
  id = [];
  url: string;

  constructor(
    private GroupeCompetenceService: GroupeCompetenceService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.GroupeCompetenceService.getGrpCompetences().subscribe(
      (data : any) => {
        this.grpCompetences = data,
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
    this.router.navigate(['/acceuil/liste/groupeCompetences']);
  }

  confirmModalNo() {
    return this.reloadComponent();
  }

  currentRoute() {
    var split;
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    split = this.url.split('/');
    if((split[5] == `modifier`) || (split[5] == `details`)) {
      return true;
    }
    return false;
  }

  onClickBtnDetails(toLoad) {
    this.reloadComponent();
    return this.router.navigate([`/acceuil/liste/groupeCompetences/${toLoad}/details`]);
  }

  onClickBtnPut(id) {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    return this.router.navigate([`/acceuil/liste/groupeCompetences/${id}/modifier`]);
  }

  onClickBtnDelete() {
    var toDelete: number;
    toDelete = this.getIdOnUrl();
    console.log(toDelete);
     return this.GroupeCompetenceService.deleteGrpCompetence(toDelete).subscribe(
      (res: any) => { 
        
        console.log(res)
      }
    ),this.reloadComponent();
  }
}
