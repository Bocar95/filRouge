import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { ConfirmationService } from 'primeng/api';
import { ReferentielService } from 'src/app/service/referentielService/referentiel.service';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

@Component({
  selector: 'app-details-referentiel',
  templateUrl: './details-referentiel.component.html',
  styleUrls: ['./details-referentiel.component.css']
})

export class DetailsReferentielComponent implements OnInit {
@ViewChild("cardToPrint") cardToPrint: ElementRef;

  referentiel;
  grpCompetences = [];
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
    this.referentielService.getById(this.getIdOnUrl()).subscribe(
      (data : any) => {
        this.referentiel = data,
        this.grpCompetences = data["groupeCompetences"],
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

  public openPDF(libelle):void {
    let DATA = this.cardToPrint.nativeElement;
        
    html2canvas(DATA).then(canvas => {
      let fileWidth = 208;
      let fileHeight = canvas.height * fileWidth / canvas.width;
    // console.log(canvas.height);
      const FILEURI = canvas.toDataURL('image/png')
      let PDF = new jsPDF('p', 'mm', 'a4');
      let position = -100;
      PDF.addImage(FILEURI, 'PNG', 0, position, fileWidth, fileHeight);
     
      PDF.save(`${libelle}.pdf`);
    });     
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

}
