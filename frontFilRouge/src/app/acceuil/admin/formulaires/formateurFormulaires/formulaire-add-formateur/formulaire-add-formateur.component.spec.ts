import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulaireAddFormateurComponent } from './formulaire-add-formateur.component';

describe('FormulaireAddFormateurComponent', () => {
  let component: FormulaireAddFormateurComponent;
  let fixture: ComponentFixture<FormulaireAddFormateurComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulaireAddFormateurComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulaireAddFormateurComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
