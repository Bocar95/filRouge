import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulaireAddPromoComponent } from './formulaire-add-promo.component';

describe('FormulaireAddPromoComponent', () => {
  let component: FormulaireAddPromoComponent;
  let fixture: ComponentFixture<FormulaireAddPromoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulaireAddPromoComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulaireAddPromoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
