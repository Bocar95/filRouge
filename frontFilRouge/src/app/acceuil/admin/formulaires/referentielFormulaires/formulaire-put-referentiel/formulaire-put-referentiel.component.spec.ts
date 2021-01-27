import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulairePutReferentielComponent } from './formulaire-put-referentiel.component';

describe('FormulairePutReferentielComponent', () => {
  let component: FormulairePutReferentielComponent;
  let fixture: ComponentFixture<FormulairePutReferentielComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulairePutReferentielComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulairePutReferentielComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
