import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { ConfirmationService } from 'primeng/api';
import { GroupeCompetenceService } from 'src/app/service/groupeCompetenceService/groupe-competence.service';

@Component({
  selector: 'app-list-grp-competence',
  templateUrl: './list-grp-competence.component.html',
  styleUrls: ['./list-grp-competence.component.css']
})

export class ListGrpCompetenceComponent implements OnInit {

  grpCompetences = [];
  competencesElements = [];
  competences = [];
  snapshot: RouterStateSnapshot;
  id = [];
  url: string;
  disabled = true;

  first = 0;
  rows = 5;
  clonedProducts: { } = {};
  index: number = null;
  lastIndex = -1;

  elseResponse = 'Il n\'y a pas encore de competences dédier à ce groupe de compétence.';

  constructor(
    private groupeCompetenceService: GroupeCompetenceService,
    private router: Router,
    private confirmationService: ConfirmationService
  ) { }

  ngOnInit(): void {
    this.groupeCompetenceService.getGrpCompetences().subscribe(
      (data : any) => {
        this.grpCompetences = data,
        console.log(data)
      }
    );
  }

  showCompetencesById(id){
    return this.groupeCompetenceService.getCompetencesOfGrpCompetence(id).subscribe(
      (res: any) => {
        this.competencesElements = res;
        this.competences = this.competencesElements["competences"];
        console.log(res);
      }
    );
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
    return this.router.navigate([`/acceuil/liste/groupeCompetences`]);
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

  onRowEditInit(grpCompetence) {
    this.clonedProducts[grpCompetence.id] = {...grpCompetence};
  }

  onRowEditSave(grpCompetence, id) {
    console.log(grpCompetence);
    return this.groupeCompetenceService.putGrpCompetence(id, grpCompetence).subscribe(
      (res: any) => { 
        console.log(res)
      }
    );
  }

  onRowEditCancel(grpCompetence, index: number) {
    this.grpCompetences[index] = this.clonedProducts[grpCompetence.id];
    delete this.clonedProducts[grpCompetence.id];
  }

  confirm(event: Event) {
    this.confirmationService.confirm({
        target: event.target,
        message: 'Êtes-vous sure de vouloir supprimer ce grpCompetence?',
        icon: 'pi pi-exclamation-triangle',
        accept: () => {
          var toDelete: number;
          toDelete = this.getIdOnUrl();
          return this.groupeCompetenceService.deleteGrpCompetence(toDelete).subscribe(
            (res: any) => { 
              console.log(res)
            }
          ),this.reloadComponent();
        },
        reject: () => {
          // return this.reloadComponent();
        }
    });
  }

  closeAccordion() {
    this.index = this.lastIndex--;
  }

}
