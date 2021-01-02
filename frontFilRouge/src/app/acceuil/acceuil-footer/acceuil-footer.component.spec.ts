import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AcceuilFooterComponent } from './acceuil-footer.component';

describe('AcceuilFooterComponent', () => {
  let component: AcceuilFooterComponent;
  let fixture: ComponentFixture<AcceuilFooterComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AcceuilFooterComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AcceuilFooterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
