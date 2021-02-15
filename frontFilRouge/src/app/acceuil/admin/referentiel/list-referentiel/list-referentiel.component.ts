import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { ConfirmationService } from 'primeng/api';
import { ReferentielService } from 'src/app/service/referentielService/referentiel.service';

@Component({
  selector: 'app-list-referentiel',
  templateUrl: './list-referentiel.component.html',
  styleUrls: ['./list-referentiel.component.css']
})
export class ListReferentielComponent implements OnInit {

  referentiels = [];
  grpCompetences = [];
  btnAjouter = "Ajouter";
  btnNewReferentiel = "Nouveau";
  btnModifier = "Modifier";
  btnSupprimer = "Supprimer";
  snapshot: RouterStateSnapshot;
  id = [];
  url: string;
  first = 0;
  rows = 5;
  clonedProducts: { } = {};
  index: number = null;
  lastIndex = -1;

  constructor(
    private referentielService: ReferentielService,
    private router: Router,
    private confirmationService: ConfirmationService
  ) { }

  ngOnInit(): void {
    this.referentielService.getReferentiels().subscribe(
      (data : any) => {
        this.referentiels = data,
        console.log(data)
      }
    )
  }

  showGrpCompetenceById(id){
    return this.referentielService.getGrpCompOfRefById(id).subscribe(
      (res: any) => {
        this.grpCompetences = res["groupeCompetences"];
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
    this.router.navigate(['/acceuil/liste/referentiels']);
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
    return this.router.navigate([`/acceuil/liste/referentiels/${toLoad}/details`]);
  }

  onClickBtnPut(id) {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    return this.router.navigate([`/acceuil/liste/referentiels/${id}/modifier`]);
  }

  confirm(event: Event) {
    this.confirmationService.confirm({
        target: event.target,
        message: 'Êtes-vous sure de vouloir supprimer ce référentiel?',
        icon: 'pi pi-exclamation-triangle',
        accept: () => {
          var toDelete: number;
          toDelete = this.getIdOnUrl();
          return this.referentielService.deleteReferentiel(toDelete).subscribe(
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
