import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulaireAddReferentielComponent } from './formulaire-add-referentiel.component';

describe('FormulaireAddReferentielComponent', () => {
  let component: FormulaireAddReferentielComponent;
  let fixture: ComponentFixture<FormulaireAddReferentielComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulaireAddReferentielComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulaireAddReferentielComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
