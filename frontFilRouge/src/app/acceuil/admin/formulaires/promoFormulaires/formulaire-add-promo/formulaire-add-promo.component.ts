import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ReferentielService } from 'src/app/service/referentielService/referentiel.service';
import { FormateurUserService } from '../../../../../service/formateurUserService/formateur-user.service';
import { ApprenantUserService } from '../../../../../service/apprenantUserService/apprenant-user.service';
import { PromoService } from 'src/app/service/promoService/promo.service';
import { DatePipe } from '@angular/common';

@Component({
  selector: 'app-formulaire-add-promo',
  templateUrl: './formulaire-add-promo.component.html',
  styleUrls: ['./formulaire-add-promo.component.css']
})
export class FormulaireAddPromoComponent implements OnInit {

  addingPromo: FormGroup;
  titreFormControl = new FormControl('', [Validators.required]);
  descriptifFormControl = new FormControl('', [Validators.required]);
  anneeFormControl = new FormControl();
  referentielFormControl = new FormControl();
  formateurFormControl = new FormControl();
  apprenantFormControl = new FormControl();
  nomGroupePrincipalFormControl = new FormControl('', [Validators.required])
  referentielList = [];
  formateurList = [];
  apprenantList = [];
  btnText = 'Ajouter';

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private promoService : PromoService,
    private referentielService: ReferentielService,
    private formateurService : FormateurUserService,
    private apprenantService: ApprenantUserService
  ) { }

  ngOnInit(): void {
    this.referentielService.getReferentiels().subscribe(
      (referentielData : any)=>{
        this.referentielList = referentielData,
        console.log(referentielData)
      });
    this.formateurService.getFormateurs().subscribe(
      (formateurData : any)=>{
        this.formateurList = formateurData,
        console.log(formateurData)
      });
    this.apprenantService.getApprenants().subscribe(
      (apprenantData : any)=>{
        this.apprenantList = apprenantData,
        console.log(apprenantData)
    })
    this.addingPromo = this.formBuilder.group({
      titre : this.titreFormControl,
      description : this.descriptifFormControl,
      annee : this.transform(this.anneeFormControl),
      referentiels : this.referentielFormControl,
      formateurs : this.formateurFormControl,
      apprenants : this.apprenantFormControl,
      nomGroupePrincipal : this.nomGroupePrincipalFormControl
    });
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/ajouter/promo']);
    alert("Ajouter avec success");
  }

  transform(value) {
    var datePipe = new DatePipe("en-US");
     value = datePipe.transform(value, 'yyyy/dd/MM/');
     return value;
 }

  onClickBtnAdd() {
    //console.log(this.addingPromo.value);
    if(this.addingPromo.value){
      return this.promoService.addPromo(this.addingPromo.value).subscribe(
        (addingRes: any) => {
          console.log(addingRes)
       }
      ),this.reloadComponent();
    }
  }

}
