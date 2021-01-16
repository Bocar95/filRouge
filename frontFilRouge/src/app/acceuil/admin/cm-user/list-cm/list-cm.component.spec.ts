import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListCmComponent } from './list-cm.component';

describe('ListCmComponent', () => {
  let component: ListCmComponent;
  let fixture: ComponentFixture<ListCmComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ListCmComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ListCmComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
